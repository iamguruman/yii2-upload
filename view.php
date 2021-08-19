<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kp\models\MKpUploads */

$this->title = $model->filename_original;

$this->params['breadcrumbs'][] = \app\modules\kp\Module::getBreadcrumbs();

if($model->kp){
    $this->params['breadcrumbs'][] = $model->kp->getBreadcrumbs();

    $this->params['breadcrumbs'][] = ['label' => 'Файлы',
        'url' => ['/kp/kp/view', 'id' => $model->kp->id, 'tab' => 'files']];
}

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mkp-uploads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= aHtmlButtonUpdate($model, 1) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kp_id',
            'team_id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'markdel_by',
            'markdel_at',
            'filename_original',
            'md5',
            'ext',
            'mimetype',
            'size',
            'type_anketa',
        ],
    ]) ?>

</div>
