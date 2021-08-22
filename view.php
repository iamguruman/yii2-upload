<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \app\modules\customer_review\models\MReviewUpload */

$this->title = $model->filename_original;

$this->params['breadcrumbs'][] = "Отзывы покупателей";

if($model->object){
    $this->params['breadcrumbs'][] = $model->object->getBreadcrumbs();

    $this->params['breadcrumbs'][] = ['label' => 'Файлы',
        'url' => ['/customer_review/default/view', 'id' => $model->object->id, 'tab' => 'files']];
}

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mkp-uploads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= aHtmlButtonUpdate($model) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'filename_original',
            'ext',
            'mimetype',
            'type_screenshot',
            'type_goods_photo',
            'type_customer_photo',
        ],
    ]) ?>

    <?= \yii\bootstrap\Tabs::widget(['items' => [
        [
            'label' => "ID",
            'active' => "false",
            'content' => "<br>".DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'team_by',
                        'object_id',
                        'created_at',
                        'created_by',
                        'updated_at',
                        'updated_by',
                        'markdel_by',
                        'markdel_at',
                    ],
                ])
        ],
    ]]) ?>

</div>
