<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
use common\models\AwProvince;
use common\models\AwTown;
use common\models\AwCity;
/* @var $this yii\web\View */
/* @var $model common\models\AwPlayerInformation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-player-information-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'gender')->dropDownList([ '男' => '男', '女' => '女',]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'age')->textInput() ?>
        </div>


    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'height')->textInput() ?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'weight')->textInput() ?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'playing_years')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'forehand')->dropDownList([ '右手' => '右手', '双手' => '双手', '左手' => '左手',]) ?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'backhand')->dropDownList([ '双反' => '双反', '单反' => '单反',]) ?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'grade')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'singles_titles')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'doubles_titles')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <!--dropDownList(['存入数据库的值'=>'输入框显示值'])-->
            <?= $form->field($model, 'group')->dropDownList([ '银' => '银', '金' => '金', ]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'hometown_province')->dropDownList(AwProvince::find()->select('name')->indexBy('name')->column(),
                [
                    'prompt'=>'--请选择省--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['region/city']).'&province="+$(this).val(),function(data){
                            $("select#awplayerinformation-hometown_city").html(data);
                        })'
                ]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'hometown_city')->dropDownList((new AwCity())->getCityList($model->hometown_province),
                [
                    'prompt'=>'--请选择市--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['region/town']).'&province="
                        +$("select#awplayerinformation-hometown_province").val()+"&city="+$(this).val(),function(data){
                            $("select#awplayerinformation-hometown_town").html(data);
                        })'
                ]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'hometown_town')->dropDownList((new AwTown())->getTownList($model->hometown_province,$model->hometown_city),['prompt'=>'--请选择区县--']) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($model, 'residence_province')->dropDownList(AwProvince::find()->select('name')->indexBy('name')->column(),
                [
                    'prompt'=>'--请选择省--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['region/city']).'&province="+$(this).val(),function(data){
                            $("select#awplayerinformation-residence_city").html(data);
                        })'
                ]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'residence_city')->dropDownList((new AwCity())->getCityList($model->residence_province),
                [
                    'prompt'=>'--请选择市--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['region/town']).'&province="
                        +$("select#awplayerinformation-residence_province").val()+"&city="+$(this).val(),function(data){
                            $("select#awplayerinformation-residence_town").html(data);
                        })'
                ]) ?>
        </div>

        <div class="col-lg-offset-1 col-xs-2">
            <?= $form->field($model, 'residence_town')->dropDownList((new AwTown())->getTownList($model->residence_province,$model->residence_city),['prompt'=>'--请选择区县--']) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-3">
            <?= MyFunction::timeForm($model)?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-3">
            <?= $form->field($model, 'retired')->dropDownList([ 'no' => 'No', 'yes' => 'Yes',]) ?>
        </div>

        <div class="col-lg-offset-2 col-xs-3">
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true])?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-12">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
