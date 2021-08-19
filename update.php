<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */

$this->title = 'Update M Kp Uploads: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'M Kp Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
