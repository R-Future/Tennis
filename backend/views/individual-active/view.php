<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualActive */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->player0->name;
$this->params['breadcrumbs'][] = ['label' => '个人活动记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-individual-active-view">

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
            [
                'label'=>'球员',
                'value'=>$model->player0->name
            ],
//            'active',
            'create_at',
            'update_at',
            'comment',
            'is_invalidated:boolean',
        ],
    ]) ?>

</div>

<div class="aw-active-index">
<!--    <p>-->
<!--        --><?//= Html::a('添加活动', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'time',
            'place',
            'active:ntext',
            'create_at',
            // 'update_at',
            // 'comment',
            // 'is_invalidated:boolean',

//            ['class' => 'yii\grid\ActionColumn','controller'=>'active'],
        ],
    ]); ?>

</div>