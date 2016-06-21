<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualActive */

$this->title = '更新个人活动记录: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '个人活动记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-individual-active-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
