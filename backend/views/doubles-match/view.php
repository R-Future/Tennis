<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\AwTeam;
use common\models\AwArena;
use common\models\AwTournament;
/* @var $this yii\web\View */
/* @var $model common\models\AwDoublesMatch */
/* @var $searchModel backend\models\searches\AwMatchScoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider*/
$team1=AwTeam::findOne($model->team1);
$team2=AwTeam::findOne($model->team2);
$match_place=AwArena::findOne($model->match_place);
$rounds=array('0'=>'小组赛','32'=>'1/32','16'=>'1/16','8'=>'1/8','4'=>'半决赛','2'=>'决赛');
$win_loss=array('1'=>'胜','0'=>'平','-1'=>'负');

$team1=$team1->player->name.'&'.$team1->player0->name;
$team2=$team2->player->name.'&'.$team2->player0->name;
$this->title = $team1.' VS '.$team2;
$this->params['breadcrumbs'][] = ['label' => '双打比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-doubles-match-view">

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
                'label'=>'组合1',
                'value'=>$team1
            ],
            [
                'label'=>'组合2',
                'value'=>$team2
            ],
            'match_time',
            [
                'label'=>'比赛地点',
                'value'=>$match_place->name
            ],
            'entry_project',
            'field_type',
            [
                'label'=>'赛事类型',
                'value'=>AwTournament::findOne($model->tournament)->name
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
            'team1_point',
            'team2_point',
            'team1_quit',
            'team2_quit',
            'is_invalidated',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>

<div class="aw-match-score-index">

    <p>
        <?= Html::a('新增比分', ['/match-score/create','match_id'=>$model->scores], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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