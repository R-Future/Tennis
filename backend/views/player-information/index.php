<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searches\AwPlayerInformationtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '球员信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-player-information-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加球员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'gender',
            'age',
            'height',
             'weight',
            // 'hometown_province',
            // 'hometown_city',
            // 'hometown_town',
            // 'residence_province',
            // 'residence_city',
            // 'residence_town',
             'playing_years',
             'forehand',
             'backhand',
             'grade',
             'singles_titles',
             'doubles_titles',
             'group',
            // 'retired',
            // 'create_at',
            // 'update_at',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
