<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AwDoubleIndividualPoint */

$this->title = $model->player0->name;
$this->params['breadcrumbs'][] = ['label' => '双打个人积分记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-double-individual-point-view">

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
            [
                'label'=>'球员',
                'value'=>$model->player0->name
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
