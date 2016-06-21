<?php

use yii\helpers\Html;
use common\models\AwRegion;

/* @var $this yii\web\View */
/* @var $model common\models\AwArena */

$region=(new AwRegion())->findOne($model->region_id);
$this->title = '更新场馆信息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $region['city'].$region['county'], 'url' => ['region/view', 'id'=>$model->region_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新场馆信息';
?>
<div class="aw-arena-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
