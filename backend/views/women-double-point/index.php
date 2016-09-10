<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwWomenDoublePointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aw Women Double Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-women-double-point-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aw Women Double Point', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'team',
            'year',
            'week',
            'total_matches',
             'win_matches',
             'margin_bureau',
             'point',
            // 'create_at',
            // 'update_at',
            // 'is_invalidated:boolean',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
