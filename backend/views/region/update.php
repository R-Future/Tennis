<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwRegion */

$this->title = '更新地区信息: ' . ' ' . $model->city.$model->county;
$this->params['breadcrumbs'][] = ['label' => '地区信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->city.$model->county, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新地区信息';
?>
<div class="aw-region-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
