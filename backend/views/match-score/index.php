<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwMatchScoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aw Match Scores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-match-score-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aw Match Score', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'match_id',
            'set',
            'player1_score',
            'player2_score',
            // 'tie_player1_score',
            // 'tie_player2_score',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
