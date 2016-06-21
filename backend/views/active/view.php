<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AwActive */
/* @var $dataProvider yii\data\ActiveDataProvider*/
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '活动记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-active-view">

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
            'time',
            [
                'label'=>'活动地点',
                'value'=>$model->place0->name
            ],
            'active:ntext',
            'create_at',
            'update_at',
            'comment',
            'is_invalidated:boolean',
        ],
    ]) ?>

<!--活动参加人-->
    <h3>活动名单</h3>
    <table class="table table-condensed table-bordered">
        <tr>
            <?php foreach($dataProvider as $index => $value):?>
                <td class="col-xs-1"><?=$value?></td>
            <?php endforeach;?>
        </tr>   
    </table>

</div>
