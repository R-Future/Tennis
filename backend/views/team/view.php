<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AwTeam */

$this->title = $model->player->name.'&'.$model->player0->name;
$this->params['breadcrumbs'][] = ['label' => '组合信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-team-view">

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
                'label'=>'队友1',
                'value'=>$model->player->name
            ],
            [
                'label'=>'队友2',
                'value'=>$model->player0->name
            ],
            'start_at',
            'create_at',
            'update_at',
            'comment',
        ],
    ]) ?>

</div>
