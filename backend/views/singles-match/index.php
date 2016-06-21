<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwSinglesMatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '单打比赛';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-singles-match-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增比赛记录', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'player',
            'opponent',
            'match_time',
            'match_place',
             'entry_project',
             'field_type',
             'tournament',
             'round',
             'sets',
//             'scores',
            // 'win_loss',
             'player_point',
             'opponent_point',
            // 'player_quit',
            // 'opponent_quit',
            // 'is_invalidated',
            // 'create_at',
            // 'update_at',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
