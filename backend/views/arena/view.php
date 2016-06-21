<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\AwRegion;

/* @var $this yii\web\View */
/* @var $model common\models\AwArena */

$region=(new AwRegion())->findOne($model->region_id);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $region['city'].$region['county'], 'url' => ['region/view','id'=>$model->region_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-arena-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'region_id',
            'name',
            'address',
            'field_type',
            'indoor_field_number',
            'outdoor_field_number',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>
