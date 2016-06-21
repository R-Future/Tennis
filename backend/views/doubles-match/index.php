<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwDoublesMatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '双打比赛记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-doubles-match-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?//= Html::a('Create Aw Doubles Match', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'team1',
            'team2',
            'match_time',
            'match_place',
            'entry_project',
            'field_type',
            'tournament',
            'round',
             'sets',
            // 'scores',
            // 'win_loss',
            'team1_point',
            'team2_point',
            'team1_quit',
            'team2_quit',
            //'is_invalidated',
            // 'create_at',
            // 'update_at',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
