<?php

namespace app\modules\customer_review\controllers;

use app\modules\bills\models\BillUpload;
use app\modules\customer_review\models\MReview;
use app\modules\customer_review\models\MReviewUpload;
use app\modules\customer_review\models\MReviewUploadSearch;
use Yii;
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
 
 прототип таблицы:
 
 CREATE TABLE `m_<ИМЯ МОДУЛЯ>__upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `markdel_at` datetime DEFAULT NULL COMMENT 'Удалено когда',
  `markdel_by` int(11) DEFAULT NULL COMMENT 'Удалено кем',
  `isDeleted` int(11) NOT NULL DEFAULT '0',
  `filename_original` varchar(255) DEFAULT NULL COMMENT 'Оригинальное название файла',
  `md5` varchar(255) DEFAULT NULL,
  `ext` varchar(255) DEFAULT NULL COMMENT 'Расширение файла',
  `mimetype` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `this_is_last_version_of_bill_document` int(1) DEFAULT NULL COMMENT 'Это последняя версия файла',
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
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
     * Lists all M----Uploads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MReviewUploadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single M----Uploads model.
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
     * Creates a new M----Uploads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MReviewUpload();

        $model->team_by = aTeamDefaultId();
        $model->created_at = aDateNow();
        $model->created_by = aUserMyId();

        if($object = MReview::findOne(aGet('object'))){
            $model->object_id = $object->id;
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

                if(MReviewUpload::find()->andWhere(['md5' => $md5, 'object_id' => $object->id])->count() == 0){

                    $uploadModel = new MReviewUpload();  // поменять название модели
                    $uploadModel->object_id = $object->id;

                    $uploadModel->team_by = aTeamDefaultId();
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
     * Updates an existing M----Uploads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['/customer_review/default/view', 'id' => $model->object_id, 'tab' => 'files']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing M----Uploads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return aControllerActionMarkdel($this, $model,
            ['/customer_review/default/view', 'id' => $model->object_id, 'tab' => 'files'],
            ['/customer_review/default/view', 'id' => $model->object_id, 'tab' => 'files']
        );

        return $this->redirect(['index']);
    }

    /**
     * Finds the M----Uploads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MReviewUpload the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MReviewUpload::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
