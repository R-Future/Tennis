<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AwPlayerInformation;
use common\base\MyFunction;
/* @var $this yii\web\View */
/* @var $model common\models\AwTeam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-team-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'player1')->dropDownList(AwPlayerInformation::find()->select(['name','id'])->indexBy('id')->column())?>

    <?= $form->field($model, 'player2')->dropDownList(AwPlayerInformation::find()->select(['name','id'])->indexBy('id')->column())?>

    <?= $form->field($model, 'start_at')->textInput(['value'=>MyFunction::getCurrentDate()]) ?>

    <?= MyFunction::timeForm($model)?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
