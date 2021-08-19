<?php

namespace app\modules\kp\controllers;

use app\modules\bills\models\BillUpload;
use app\modules\kp\models\Kp;
use Yii;
use app\modules\kp\models\MKpUploads;
use app\modules\kp\models\MKpUploadsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UploadController implements the CRUD actions
 *
 * контроллер для загрузки файлов в проект
 *
 */
class UploadController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all MKpUploads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MKpUploadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MKpUploads model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MKpUploads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MKpUploads();

        $model->created_at = aDateNow();
        $model->created_by = aUserMyId();

        if($kp = Kp::findOne(aGet('kp'))){
            $model->kp_id = $kp->id;
        }

        $directory = Yii::getAlias('@webroot/_uploads') . DIRECTORY_SEPARATOR;

        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');

            // перебираю каждый файл из загруженных
            // в данном случае вариант загрузки нескольких файлов
            // иногда бывают случаи когда нельзя несколько файлов грузить сразу
            foreach ($model->files as $uploadedFile){

                $md5 = md5_file($uploadedFile->tempName);

                $fileName = $md5 . '.' . $uploadedFile->extension;

                $filePath = $directory . $fileName;

                if(!file_exists($filePath)){
                    $uploadedFile->saveAs($filePath);
                }

                if(MKpUploads::find()->andWhere(['md5' => $md5, 'kp_id' => $kp->id])->count() == 0){

                    $uploadModel = new MKpUploads();  // поменять название модели
                    $uploadModel->kp_id = $kp->id;

                    $uploadModel->team_id = aTeamDefaultId();
                    $uploadModel->created_at = aDateNow();
                    $uploadModel->created_by = aUserMyId();
                    $uploadModel->md5 = $md5;
                    $uploadModel->filename_original = $uploadedFile->name;
                    $uploadModel->ext = $uploadedFile->extension;
                    $uploadModel->mimetype = $uploadedFile->type;
                    $uploadModel->size = $uploadedFile->size;

                    // добавить свои проверки для массовых расстановок галочек
                    //if($model->type_ustavnoi_doc){
                    //    $uploadModel->type_ustavnoi_doc = $model->type_ustavnoi_doc;
                    //}

                    if($uploadModel->save()){ } else { ddd($uploadModel->errors); }

                }

            }

            aReturnto();
            //if ($model->save()) {
            //    return $this->redirect(['view', 'id' => $model->id]);
            //}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MKpUploads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MKpUploads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return aControllerActionMarkdel($this, $model,
            ['/kp/kp/view', 'id' => $model->kp_id, 'tab' => 'files'],
            ['/kp/kp/view', 'id' => $model->kp_id, 'tab' => 'files']
        );

        return $this->redirect(['index']);
    }

    /**
     * Finds the MKpUploads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MKpUploads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MKpUploads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
