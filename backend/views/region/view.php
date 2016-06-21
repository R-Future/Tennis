<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\AwRegion */

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwArenaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->city.$model->county;
$this->params['breadcrumbs'][] = ['label' => '地区信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-region-view">

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
//            'id',
            'province',
            'city',
            'county',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>

<!--
user:Future
time:2016.5.19 15:43
modify：
-->

<div class="aw-arena-index">

    <p>
        <?= Html::a('新增球馆', ['arena/create','region_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'region_id',
            'name',
            'address',
            'field_type',
            'indoor_field_number',
            'outdoor_field_number',
            // 'create_at',
            // 'update_at',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn','controller'=>'arena'],
        ],
    ]); ?>

</div>