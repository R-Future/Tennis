<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AwPlayerInformation;
use common\base\MyFunction;
/* @var $this yii\web\View */
/* @var $model common\models\AwWomenIndividualPoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-women-individual-point-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'player')->dropDownList(AwPlayerInformation::find()->select('name')->where(['gender'=>'女'])->indexBy('id')->column()) ?>

    <?= $form->field($model, 'year')->textInput(['value'=>date('Y')]) ?>

    <?= $form->field($model, 'week')->textInput(['value'=>date('W')]) ?>

    <?= $form->field($model, 'total_matches')->textInput() ?>

    <?= $form->field($model, 'win_matches')->textInput() ?>

    <?= $form->field($model, 'margin_bureau')->textInput() ?>

    <?= $form->field($model, 'point')->textInput() ?>

    <?= MyFunction::timeForm($model)?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
