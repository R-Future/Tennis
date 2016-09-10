<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwDeductPointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aw Deduct Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-deduct-point-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aw Deduct Point', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'player',
            'point',
            'entry_project',
            'match_time',
            // 'create_at',
            // 'update_at',
            // 'is_invalidated',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
