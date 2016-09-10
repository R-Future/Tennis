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

    <?= $form->field($model, 'player')->dropDownList(AwPlayerInformation::find()->select('name')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'rank_type')->dropDownList([ '男单' => '男单', '女单' => '女单', '混单' => '混单', '双打个人' => '双打个人', '双打' => '双打', ], ['prompt' => '--请选择排名类别--']) ?>

    <?= $form->field($model, 'total_points')->textInput() ?>

    <?= $form->field($model, 'current_rank')->textInput() ?>

    <?= $form->field($model, 'rank_lift')->textInput() ?>

    <?= $form->field($model, 'win_matches')->textInput() ?>

    <?= $form->field($model, 'total_matches')->textInput() ?>

    <?= $form->field($model, 'next_week_deduct_point')->textInput() ?>

    <?= $form->field($model, 'highest_rank')->textInput() ?>

    <?= $form->field($model, 'no1_weeks')->textInput() ?>

    <?= $form->field($model, 'consecutive_no1_weeks')->textInput() ?>

    <?= $form->field($model, 'longest_no1_weeks')->textInput() ?>

    <?= $form->field($model, 'margin_bureau')->textInput() ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'week')->textInput() ?>

    <?= $form->field($model, 'highest_rank_start_at')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
