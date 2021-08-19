<?php

/**
 *
 * список файлов к объекту
 * добавление файлов можно делать только к объекту, поэтому кнопки без объекта не будет выводиться
 *
 */

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
        <?= aIfModuleControllerAction('kp', 'kp', 'view') ?
            Html::a('Добавить файл',
                ['/kp/upload/create',
                    'kp' => aGet('id'),
                    'returnto' => urlencode($_SERVER['REQUEST_URI']."&tab=files")
                ],
                ['class' => 'btn btn-success'])
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

            aIfModuleControllerAction("kp", "kp", "view") ? ['visible' => false] : [
                'attribute' => 'kp_id',
                'value' => 'kp.urlTo',
                'format' => 'raw',
            ],

            'filename_original',

            'mimetype',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{download} {view}', 'buttons' => [

                    'download' => function($url, \app\modules\kp\models\MKpUploads $model, $key){
                    return Html::a("<i class='fas fa-download'></i>",
                        ["/_uploads/{$model->md5}.{$model->ext}"],
                        ['data-pjax' => 0, 'target' => '_blank']);
                },

                'view' => function($url, \app\modules\kp\models\MKpUploads $model, $key){
                    return Html::a("<i class='fas fa-eye'></i>", ['/kp/upload/view', 'id' => $model->id], ['data-pjax' => 0]);
                },

            ]],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
