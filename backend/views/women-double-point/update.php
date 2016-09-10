<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwWomenDoublePoint */

$this->title = 'Update Aw Women Double Point: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aw Women Double Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aw-women-double-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
