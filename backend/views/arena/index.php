<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwArenaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aw Arenas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-arena-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aw Arena', ['create','region_id'=>null], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'region_id',
            'name',
            'address',
            'field_type',
            // 'indoor_field_number',
            // 'outdoor_field_number',
            // 'create_at',
            // 'update_at',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
