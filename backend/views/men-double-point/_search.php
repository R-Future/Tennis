<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searches\AwMenDoublePointSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-men-double-point-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'team') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'week') ?>

    <?= $form->field($model, 'total_matches') ?>

    <?php // echo $form->field($model, 'win_matches') ?>

    <?php // echo $form->field($model, 'margin_bureau') ?>

    <?php // echo $form->field($model, 'point') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'is_invalidated')->checkbox() ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
