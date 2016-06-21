<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AwPlayerInformation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '球员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-player-information-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'name',
            'gender',
            'age',
            'height',
            'weight',
            'hometown_province',
            'hometown_city',
            'hometown_town',
            'residence_province',
            'residence_city',
            'residence_town',
            'playing_years',
            'forehand',
            'backhand',
            'grade',
            'singles_titles',
            'doubles_titles',
            'group',
            'retired',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>
