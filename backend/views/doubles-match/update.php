<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwDoublesMatch */

$this->title = '更新比赛信息: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '双打比赛记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-doubles-match-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
