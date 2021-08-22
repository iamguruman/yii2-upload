<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\customer_review\models\MReviewUpload */

$this->title = "Файл {$model->id}";

$this->params['breadcrumbs'][] = ['label' => 'Отзывы покупателей', 'url' => ['/customer_review/']];

$this->params['breadcrumbs'][] = \app\modules\kp\Module::getBreadcrumbs();

if($model->object){
    $this->params['breadcrumbs'][] = $model->object->getBreadcrumbs();

    $this->params['breadcrumbs'][] = ['label' => 'Файлы',
        'url' => ['/kp/kp/view', 'id' => $model->object->id, 'tab' => 'files']];
}
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="mkp-uploads-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= aHtmlButtonDelete($model) ?>
    </p>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
