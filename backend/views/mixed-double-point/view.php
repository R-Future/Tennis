<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AwMixedDoublePoint */

$team=\common\models\AwTeam::findOne($model->team);
$this->title = $team->player->name.'&'.$team->player0->name;
$this->params['breadcrumbs'][] = ['label' => 'Aw Mixed Double Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-mixed-double-point-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            [
                'label'=>'组合',
                'value'=>$team->player->name.'&'.$team->player0->name
            ],
            'year',
            'week',
            'total_matches',
            'win_matches',
            'margin_bureau',
            'point',
            'create_at',
            'update_at',
            'is_invalidated:boolean',
            'comment',
        ],
    ]) ?>

</div>
