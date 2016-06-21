<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\AwTournament */

/* @var $searchModel backend\models\searches\AwPointTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '赛事信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-tournament-view">

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
            'name',
            'level',
            'prize',
            'create_at',
            'update_at',
            'is_invalidated:boolean',
            'comment',
        ],
    ]) ?>

</div>

<!--
author: Future
time: 17:08 20.5.2016
-->
<div class="aw-point-type-index">

    <p>
        <?= Html::a('添加积分规则', ['point-type/create', 'tournament_id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'tournament',
            'round',
            'winner_point',
            'loser_point',
            'penalty',
            // 'create_at',
            // 'update_at',
            // 'is_invalidated:boolean',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn','controller'=>'point-type'],
        ],
    ]); ?>

</div>