<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mkp-uploads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= (aIfModuleControllerAction("kp", "upload", "view") &&
            aUserMyId() == 1) ? $form->field($model, 'kp_id')->textInput() : null ?>

    <?= (aIfModuleControllerAction("kp", "upload", "view") &&
        aUserMyId() == 1) ? $form->field($model, 'filename_original')->textInput(['maxlength' => true]) : null ?>

    <?= aIfModuleControllerAction("kp", "upload", "create") ?
        $form->field($model, 'files[]')
            ->fileInput(['multiple' => true])
        //->fileInput(['multiple' => true])
        : null ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
