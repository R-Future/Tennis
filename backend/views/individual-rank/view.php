<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualRank */

$this->title = $model->player0->name;
$this->params['breadcrumbs'][] = ['label' => '个人排名信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-individual-rank-view">

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
            [
                'label'=>'球员',
                'value'=>$model->player0->name
            ],
            'rank_type',
            'total_points',
            'current_rank',
            'rank_lift',
            'win_matches',
            'total_matches',
            'next_week_deduct_point',
            'highest_rank',
            'no1_weeks',
            'consecutive_no1_weeks',
            'longest_no1_weeks',
            'margin_bureau',
            'year',
            'week',
            'highest_rank_start_at',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>
