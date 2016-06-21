<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;

/* @var $this yii\web\View */
/* @var $model common\models\AwTournament */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-tournament-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prize')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput(['value' => is_null($model->create_at)? MyFunction::getCurrentTime():$model->create_at]) ?>

    <?= $form->field($model, 'update_at')->textInput(['value' => MyFunction::getCurrentTime()]) ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
