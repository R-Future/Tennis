<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwPointType */
/* @var $tournament array*/

$this->title = '更新积分规则: ' . ' ' . ($model->point_type==0? '小组赛':$model->point_type);
$this->params['breadcrumbs'][] = ['label' => $tournament[0]['name'], 'url' => ['tournament/view','id'=>$model->tournament]];
$this->params['breadcrumbs'][] = ['label' => $model->point_type==0? '小组赛':$model->point_type, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-point-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tournament' => $tournament
    ]) ?>

</div>
