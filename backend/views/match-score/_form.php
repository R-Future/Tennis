<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AwMatchScore */
/* @var $form yii\widgets\ActiveForm */
/* @var $match_id string */
?>

<div class="aw-match-score-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(isset($match_id)){
        echo $form->field($model,'match_id')->textInput(['value'=>$match_id]);
    }else{
        echo $form->field($model, 'match_id')->textInput(['maxlength' => true]);
    }?>


    <?= $form->field($model, 'set')->textInput() ?>

    <?= $form->field($model, 'player1_score')->textInput() ?>

    <?= $form->field($model, 'player2_score')->textInput() ?>

    <?= $form->field($model, 'tie_player1_score')->textInput() ?>

    <?= $form->field($model, 'tie_player2_score')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
