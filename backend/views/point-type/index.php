<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwPointTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aw Point Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-point-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aw Point Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tournament',
            'point_type',
            'winner_point',
            'loser_point',
            // 'create_at',
            // 'update_at',
            // 'is_invalidated:boolean',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
