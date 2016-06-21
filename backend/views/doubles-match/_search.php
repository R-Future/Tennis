<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searches\AwDoublesMatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-doubles-match-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'team1') ?>

    <?= $form->field($model, 'team2') ?>

    <?= $form->field($model, 'match_time') ?>

    <?= $form->field($model, 'match_place') ?>

    <?php // echo $form->field($model, 'entry_project') ?>

    <?php // echo $form->field($model, 'field_type') ?>

    <?php // echo $form->field($model, 'tournament') ?>

    <?php // echo $form->field($model, 'point_type') ?>

    <?php // echo $form->field($model, 'sets') ?>

    <?php // echo $form->field($model, 'scores') ?>

    <?php // echo $form->field($model, 'win_loss') ?>

    <?php // echo $form->field($model, 'winner_point') ?>

    <?php // echo $form->field($model, 'loser_point') ?>

    <?php // echo $form->field($model, 'team1_quit') ?>

    <?php // echo $form->field($model, 'team2_quit') ?>

    <?php // echo $form->field($model, 'is_invalidated') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
