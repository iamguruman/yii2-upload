<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */

$this->title = 'Добавить файл';

$this->params['breadcrumbs'][] = ['label' => 'Коммерческие предложения', 'url' => ['/kp']];

if($model->kp){
    $this->params['breadcrumbs'][] = $model->kp->getBreadcrumbs();

    $this->params['breadcrumbs'][] = ['label' => 'Файлы',
        'url' => ['/kp/kp/view', 'id' => $model->kp->id, 'tab' => 'files']];
}


$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mkp-uploads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
