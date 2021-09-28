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
use app\modules\customer_review\models\MReviewUpload;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\kp\models\MKpUploadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$module = "vacancy";
$controller = "upload";
$action = "index";

if(aIfModuleControllerAction($module, $controller, $action)){
    $this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => ["/{$module}/"]];
    $this->title = 'Файлы';
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="mkp-uploads-index">

    <?= aIfModuleControllerAction($module, $controller, $action) ?
        aH1(Html::encode($this->title))
    : null  ?>

    <p>
        <?= aIfModuleControllerAction($module, $controller, $action) ?
            Html::a('Добавить', 
                    ["/{$module}/{$controller}/create", 
                     'returnto' => urlencode($_SERVER['REQUEST_URI']."&tab=files")], 
                    ['class' => 'btn btn-success'])
            : null  ?> 
        
        <?= aIfModuleControllerAction($module, 'route', 'view') ?
            Html::a('Добавить',
                ["/{$module}/{$controller}/create",
                    'object' => aGet('id'),
                    'returnto' => urlencode($_SERVER['REQUEST_URI']."&tab=files")],
                ['class' => 'btn btn-success'])
            : null  ?>
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

            aIfModuleControllerAction($module, "default", "view") ? ['visible' => false] : [
                'attribute' => 'object_id',
                'value' => 'object.urlTo',
                'format' => 'raw',
            ],

            'filename_original',

            'mimetype',

            [
                'attribute' => 'type_screenshot',
                'header' => 'Скрин',
                'headerOptions' => ['style' => 'width:80px;']
            ],

            [
                'attribute' => 'type_goods_photo',
                'header' => 'Товар',
                'headerOptions' => ['style' => 'width:80px;']
            ],

            [
                'attribute' => 'type_customer_photo',
                'header' => 'Клиент',
                'headerOptions' => ['style' => 'width:80px;']
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{download} {view}', 'buttons' => [

                    'download' => function($url, MReviewUpload $model, $key){
                    return Html::a("<i class='fas fa-download'></i>",
                        ["/_uploads/{$model->md5}.{$model->ext}"],
                        ['data-pjax' => 0, 'target' => '_blank']);
                },

                'view' => function($url, MReviewUpload $model, $key){
                    return Html::a("<i class='fas fa-eye'></i>", ['/customer_review/upload/view', 'id' => $model->id], ['data-pjax' => 0]);
                },

            ]],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
