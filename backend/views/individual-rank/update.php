<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualRank */

$this->title = '更新个人排名信息: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '个人排名信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-individual-rank-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
