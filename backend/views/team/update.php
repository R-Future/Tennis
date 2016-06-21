<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwTeam */

$this->title = '更新组合信息: ' . ' ' . $model->player->name.'&'.$model->player0->name;
$this->params['breadcrumbs'][] = ['label' => '组合信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->player->name.'&'.$model->player0->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-team-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
