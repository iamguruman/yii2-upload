<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mkp-uploads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= aUserMyId() == 1 ? $form->field($model, 'kp_id')->textInput() : null ?>

    <?= aUserMyId() == 1 ? $form->field($model, 'filename_original')->textInput(['maxlength' => true]) : null ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
