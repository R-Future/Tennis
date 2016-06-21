<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AwPlayerInformation;
/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualRank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-individual-rank-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'player')->dropDownList(AwPlayerInformation::find()->select('name')->indexBy('id')->all()) ?>

    <?= $form->field($model, 'rank_type')->dropDownList([ '男单' => '男单', '女单' => '女单', '混单' => '混单', '双打个人' => '双打个人', '双打' => '双打', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'total_points')->textInput() ?>

    <?= $form->field($model, 'highest_rank')->textInput() ?>

    <?= $form->field($model, 'no1_weeks')->textInput() ?>

    <?= $form->field($model, 'consecutive_no1_weeks')->textInput() ?>

    <?= $form->field($model, 'longest_no1_weeks')->textInput() ?>

    <?= $form->field($model, 'margin_bureau')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
