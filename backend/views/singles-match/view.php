<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\AwSinglesMatch */

/* @var $searchModel backend\models\searches\AwMatchScoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$rounds=array('0'=>'小组赛','32'=>'1/32','16'=>'1/16','8'=>'1/8','4'=>'半决赛','2'=>'决赛');
$win_loss=array('1'=>'胜','0'=>'平','-1'=>'负');

$this->title = $model->match_time;
$this->params['breadcrumbs'][] = ['label' => '单打比赛记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-singles-match-view">

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
            [
                'label'=>'球员1',
                'value'=>$model->player0->name
            ],
            [
                'label'=>'球员2',
                'value'=>$model->opponent0->name
            ],
            'match_time',
            [
                'label'=>'比赛地点',
                'value'=>$model->matchPlace->name
            ],
            'entry_project',
            'field_type',
            [
                'label'=>'赛事类型',
                'value'=>$model->tournament0->name
            ],
            [
                'label'=>'轮次',
                'value'=>$rounds[$model->round]
            ],
            'sets',
            [
                'label'=>'胜负',
                'value'=>$win_loss[$model->win_loss]
            ],
            'player_point',
            'opponent_point',
            'player_challenger',
            'opponent_challenger',
            'player_quit',
            'opponent_quit',
            'is_invalidated',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>
<!-- 
每场比赛对应的比分
 -->
<div class="aw-match-score-index">

    <p>
        <?= Html::a('新增比分', ['/match-score/create','match_id'=>$model->scores], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'match_id',
            'set',
            'player1_score',
            'player2_score',
             'tie_player1_score',
             'tie_player2_score',

            ['class' => 'yii\grid\ActionColumn','controller'=>'match-score'],
        ],
    ]); ?>

</div>