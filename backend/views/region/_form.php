<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AwRegion */
/* @var $form yii\widgets\ActiveForm */
use common\models\AwProvince;
use common\models\AwCity;
use common\models\AwTown;

$cityModel=new AwCity();
?>
<div class="aw-region-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'province')->dropDownList(AwProvince::find()->select('name')->indexBy('name')->column(),
                [
                    'prompt'=>'--请选择省--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['region/city']).'&province="+$(this).val(),function(data){
                            $("select#awregion-city").html(data);
                        })'
                ]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'city')->dropDownList($cityModel->getCityList($model->province),
                [
                    'prompt'=>'--请选择市--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['region/town']).'&province="
                        +$("select#awregion-province").val()+"&city="+$(this).val(),function(data){
                            $("select#awregion-county").html(data);
                        })'
                ]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'county')->dropDownList((new AwTown())->getTownList($model->province,$model->city),['prompt'=>'--请选择区县--']) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-3">
            <?= $form->field($model, 'create_at')->textInput(['value'=> is_null($model->create_at)? date('Y-m-d H:m:s'):$model->create_at]) ?>
        </div>

        <div class="col-lg-offset-2 col-xs-3">
            <?= $form->field($model, 'update_at')->textInput(['value'=> date('Y-m-d h:m:s')]) ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-8">
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-8">
            <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
