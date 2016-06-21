<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searches\AwPlayerInformationtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-player-information-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'age') ?>

    <?= $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'hometown') ?>

    <?php // echo $form->field($model, 'residence') ?>

    <?php // echo $form->field($model, 'playing_years') ?>

    <?php // echo $form->field($model, 'forehand') ?>

    <?php // echo $form->field($model, 'backhand') ?>

    <?php // echo $form->field($model, 'grade') ?>

    <?php // echo $form->field($model, 'titles') ?>

    <?php // echo $form->field($model, 'group') ?>

    <?php // echo $form->field($model, 'retired') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
