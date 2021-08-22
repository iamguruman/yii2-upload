<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mkp-uploads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= (aIfModuleControllerAction("customer_review", "upload", "view") &&
            aUserMyId() == 1) ? $form->field($model, 'kp_id')->textInput() : null ?>

    <?= (aIfModuleControllerAction("customer_review", "upload", "view") &&
        aUserMyId() == 1) ? $form->field($model, 'filename_original')->textInput(['maxlength' => true]) : null ?>

    <?= aIfModuleControllerAction("customer_review", "upload", "create") ?
        $form->field($model, 'files[]')
            ->fileInput(['multiple' => true])
        //->fileInput(['multiple' => true])
        : null ?>

    <?= aIfModuleControllerAction("customer_review", "upload", "update") ?
        $form->field($model, 'type_screenshot')->checkbox()
    : null ?>

    <?= aIfModuleControllerAction("customer_review", "upload", "update") ?
        $form->field($model, 'type_goods_photo')->checkbox()
    : null ?>

    <?= aIfModuleControllerAction("customer_review", "upload", "update") ?
        $form->field($model, 'type_customer_photo')->checkbox()
    : null ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
