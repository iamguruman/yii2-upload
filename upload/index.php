<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\kp\models\MKpUploadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if(aIfModuleControllerAction('kp', 'upload', 'index')){
    $this->title = 'Файлы';
    $this->params['breadcrumbs'][] = \app\modules\kp\Module::getBreadcrumbs();
    $this->params['breadcrumbs'][] = $this->title;

}
?>
<div class="mkp-uploads-index">

    <?= aIfModuleControllerAction('kp', 'upload', 'index') ?
            "<h1>".Html::encode($this->title)."</h1>"
    : null ?>

    <p>
        <?= aIfModuleControllerAction('kp', 'upload', 'index') ?
            Html::a('Create M Kp Uploads', ['create'], ['class' => 'btn btn-success'])
        : null ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($model){
                    return aGridVIewColumnId($model);
                }
            ],

            [
                'attribute' => 'kp_id',
                'value' => 'kp.urlTo',
                'format' => 'raw',
            ],

            'filename_original',

            'mimetype',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{download} {view}', 'buttons' => [
                'view' => function($url, \app\modules\kp\models\MKpUploads $model, $key){
                    return Html::a("<i class='fas fa-eye'></i>", ['/kp/upload/view', 'id' => $model->id], ['data-pjax' => 0]);
                },

                'download' => function($url, \app\modules\kp\models\MKpUploads $model, $key){
                    return Html::a("<i class='fas fa-download'></i>", ["/_uploads/{$model->md5}.{$model->ext}"], ['data-pjax' => 0]);
                }
            ]],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
