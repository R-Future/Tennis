<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwMenIndividualPoint */

$this->title = '更新男单积分: ' . ' ' . $model->player0->name;
$this->params['breadcrumbs'][] = ['label' => '男单积分', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->player0->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-men-individual-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
