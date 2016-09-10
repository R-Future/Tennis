<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searches\AwIndividualRankSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-individual-rank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'player') ?>

    <?= $form->field($model, 'rank_type') ?>

    <?= $form->field($model, 'total_points') ?>

    <?= $form->field($model, 'highest_rank') ?>

    <?php // echo $form->field($model, 'no1_weeks') ?>

    <?php // echo $form->field($model, 'consecutive_no1_weeks') ?>

    <?php // echo $form->field($model, 'longest_no1_weeks') ?>

    <?php // echo $form->field($model, 'margin_bureau') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'week') ?>

    <?php // echo $form->field($model, 'highest_rank_start_at') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
