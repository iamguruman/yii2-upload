<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mkp-uploads-form">

    <?php $form = ActiveForm::begin(); ?>
    
        <?= aIfModuleControllerAction("bill_sell", "upload", "create") ?
        $form->field($model, 'uploads[]')
            ->fileInput(['multiple' => true])
        //->fileInput(['multiple' => true])
        : null ?>
    
        <?php if(aIfModuleControllerAction("contracts", "upload", "update")): ?>

            <?= $form->field($model, 'filename_original')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'from_scan_signed')->checkbox() ?>
            <?= $form->field($model, 'from_original_signed')->checkbox() ?>
            <?= $form->field($model, 'from_sended_post')->checkbox() ?>
            <?= $form->field($model, 'from_sended_courier')->checkbox() ?>

            <?= $form->field($model, 'to_scan_signed')->checkbox() ?>
            <?= $form->field($model, 'to_original_signed')->checkbox() ?>
            <?= $form->field($model, 'to_sended_post')->checkbox() ?>
            <?= $form->field($model, 'to_sended_courier')->checkbox() ?>

        <?php endif; ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
