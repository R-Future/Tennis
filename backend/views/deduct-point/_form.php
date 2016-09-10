<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;

/* @var $this yii\web\View */
/* @var $model common\models\AwDeductPoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-deduct-point-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'player')->textInput() ?>

    <?= $form->field($model, 'point')->textInput() ?>

    <?= $form->field($model, 'entry_project')->dropDownList([ MyFunction::EntryProject()['男单'] => '男单', MyFunction::EntryProject()['女单'] => '女单', MyFunction::EntryProject()['混单'] => '混单', MyFunction::EntryProject()['男双'] => '男双', MyFunction::EntryProject()['女双'] => '女双', MyFunction::EntryProject()['混双'] => '混双', MyFunction::EntryProject()['双打'] => '双打', ], ['prompt' => '--请选择参赛类型--']) ?>

    <?= $form->field($model, 'match_time')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <?= $form->field($model, 'is_invalidated')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
