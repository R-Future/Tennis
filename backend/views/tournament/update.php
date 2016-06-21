<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwTournament */

$this->title = '更新赛事信息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '赛事信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-tournament-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
