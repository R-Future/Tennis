<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\AwIndividualActiveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-individual-active-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'player') ?>

    <?= $form->field($model, 'active') ?>

    <?= $form->field($model, 'create_at') ?>

    <?= $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'is_invalidated')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
