<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searches\AwMatchScoreSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-match-score-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'match_id') ?>

    <?= $form->field($model, 'set') ?>

    <?= $form->field($model, 'player1_score') ?>

    <?= $form->field($model, 'player2_score') ?>

    <?php // echo $form->field($model, 'tie_player1_score') ?>

    <?php // echo $form->field($model, 'tie_player2_score') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
