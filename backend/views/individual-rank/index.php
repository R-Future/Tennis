<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwIndividualRankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人排名信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-individual-rank-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?//= Html::a('Create Aw Individual Rank', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'player',
            'rank_type',
            'total_points',
            'highest_rank',
            'no1_weeks',
            'consecutive_no1_weeks',
            'longest_no1_weeks',
            // 'margin_bureau',
            // 'create_at',
            // 'update_at',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
