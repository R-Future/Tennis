<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\AwTournament;
/* @var $this yii\web\View */
/* @var $model common\models\AwPointType */
$tournament=AwTournament::findOne($model->tournament);
$this->title = $model->point_type==0? '小组赛':$model->point_type;
$this->params['breadcrumbs'][] = ['label' => $tournament['name'], 'url' => ['tournament/view','id'=>$model->tournament]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-point-type-view">

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
            'tournament',
            'point_type',
            'winner_point',
            'loser_point',
            'penalty',
            'create_at',
            'update_at',
            'is_invalidated:boolean',
            'comment',
        ],
    ]) ?>

</div>
