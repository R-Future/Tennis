<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
use common\models\AwArena;
/* @var $this yii\web\View */
/* @var $model common\models\AwActive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-active-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->textInput(['value'=>MyFunction::getCurrentDate()])?>

    <?= $form->field($model, 'place')->dropDownList(AwArena::find()->select('name')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'active')->textarea(['rows' => 6]) ?>

    <?= MyFunction::timeForm($model)?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
