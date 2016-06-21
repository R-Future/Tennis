<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwPlayerInformation */

$this->title = '更新球员信息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '球员信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aw-player-information-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
