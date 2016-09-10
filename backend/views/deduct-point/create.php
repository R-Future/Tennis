<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwDeductPoint */

$this->title = 'Create Aw Deduct Point';
$this->params['breadcrumbs'][] = ['label' => 'Aw Deduct Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-deduct-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
