<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\customer_review\models\MReviewUpload */

$this->title = 'Добавить файл';

$this->params['breadcrumbs'][] = ['label' => 'Коммерческие предложения', 'url' => ['/kp']];

if($model->object){
    $this->params['breadcrumbs'][] = $model->object->getBreadcrumbs();

    $this->params['breadcrumbs'][] = ['label' => 'Файлы',
        'url' => ['/customer_review/default/view', 'id' => $model->object->id, 'tab' => 'files']];
}


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mkp-uploads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
