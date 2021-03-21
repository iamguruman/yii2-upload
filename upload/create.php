<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */

$this->title = 'Create M Kp Uploads';
$this->params['breadcrumbs'][] = ['label' => 'M Kp Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mkp-uploads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
