<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AwMixedDoublePoint */

$this->title = 'Update Aw Mixed Double Point: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aw Mixed Double Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aw-mixed-double-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
