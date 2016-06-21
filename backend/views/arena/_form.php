<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
/* @var $this yii\web\View */
/* @var $model common\models\AwArena */
/* @var $form yii\widgets\ActiveForm */
/* @var $region_id integer*/
?>

<div class="aw-arena-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
//    var_dump($region_id);
    if($model->region_id==null){
        echo $form->field($model,'region_id')->textInput(['value'=>$region_id]);//create
    }else{
        echo $form->field($model,'region_id')->textInput();//update
    }
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field_type')->dropDownList([ '硬地' => '硬地','红土' => '红土', '草地' => '草地' ]) ?>

    <?= $form->field($model, 'indoor_field_number')->textInput() ?>

    <?= $form->field($model, 'outdoor_field_number')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput(['value'=> is_null($model->create_at)? MyFunction::getCurrentTime():$model->create_at]) ?>

    <?= $form->field($model, 'update_at')->textInput(['value' => MyFunction::getCurrentTime()]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
