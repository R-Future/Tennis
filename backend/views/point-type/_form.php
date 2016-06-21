<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;

/* @var $this yii\web\View */
/* @var $model common\models\AwPointType */
/* @var $form yii\widgets\ActiveForm */
/* @var $tournament array*/

?>

<div class="aw-point-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tournament')->dropDownList(\yii\helpers\ArrayHelper::map($tournament,'id','name')) ?>

    <?= $form->field($model, 'round')->textInput() ?>

    <?= $form->field($model, 'winner_point')->textInput() ?>

    <?= $form->field($model, 'loser_point')->textInput() ?>

    <?= $form->field($model, 'penalty')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput(['value' => is_null($model->create_at)? MyFunction::getCurrentTime():$model->create_at]) ?>

    <?= $form->field($model, 'update_at')->textInput(['value' => MyFunction::getCurrentTime()]) ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
