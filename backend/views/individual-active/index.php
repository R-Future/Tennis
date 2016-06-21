<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\AwIndividualActiveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人活动记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-individual-active-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加个人活动记录', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'player',
            'active',
            'create_at',
            'update_at',
            // 'comment',
            // 'is_invalidated:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
