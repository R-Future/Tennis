<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
use common\models\AwArena;
use common\models\AwPlayerInformation;
use common\models\AwTournament;
/* @var $this yii\web\View */
/* @var $model common\models\AwSinglesMatch */
/* @var $form yii\widgets\ActiveForm */
/**
 * 男单 -- 1
 * 女单 -- 2
 * 男双 -- 3
 * 女双 -- 4
 * 混双 -- 5
 * 双打个人 -- 6
 * 混单 -- 7
 * 双打 -- 8
 * */
?>

<div class="aw-singles-match-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $arr=AwPlayerInformation::find()->select(['name','id'])->asArray()->all();
    $players=\yii\helpers\ArrayHelper::map($arr,'id','name');
    if(isset($model->player)){
        echo $form->field($model, 'player')->dropDownList(\yii\helpers\ArrayHelper::map($players,'id','name'),['prompt'=>$players[$model->player]]);
        echo $form->field($model, 'opponent')->dropDownList(\yii\helpers\ArrayHelper::map($players,'id','name'),['prompt'=>$players[$model->opponent]]);
    }else{
        echo $form->field($model, 'player')->dropDownList(\yii\helpers\ArrayHelper::map($players,'id','name'));
        echo $form->field($model, 'opponent')->dropDownList(\yii\helpers\ArrayHelper::map($players,'id','name'));
    }
    ?>

    <?= $form->field($model, 'match_time')->textInput(['value'=>isset($model->match_time)?$model->match_time:MyFunction::getCurrentDate()]) ?>

    <?php
    $arr=AwArena::find()->select(['name','id'])->asArray()->all();
    $arenas=\yii\helpers\ArrayHelper::map($arr,'id','name');
    if(isset($model->match_place)){
       echo $form->field($model, 'match_place')->dropDownList(\yii\helpers\ArrayHelper::map($arenas,'id','name'),['prompt'=>$arenas[$model->match_place]]);
    }else{
        echo $form->field($model, 'match_place')->dropDownList(\yii\helpers\ArrayHelper::map($arenas,'id','name'));
    }
    ?>

    <?= $form->field($model, 'entry_project')->dropDownList([ '7' => '混单', '2' => '女单', '1' => '男单', ]) ?>

    <?= $form->field($model, 'field_type')->dropDownList([ '硬地' => '硬地', '红土' => '红土', '草地' => '草地',  ]) ?>

    <?php
    $arr=AwTournament::find()->select(['name','id'])->asArray()->all();
    $tournaments=\yii\helpers\ArrayHelper::map($arr,'id','name');
    if(isset($model->tournament)){
           echo $form->field($model, 'tournament')->dropDownList(\yii\helpers\ArrayHelper::map($tournaments,'id','name'),['prompt'=>$tournaments[$model->tournament]]);
        }else{
            echo $form->field($model, 'tournament')->dropDownList(\yii\helpers\ArrayHelper::map($tournaments,'id','name'));
        }
    ?>

    <?= $form->field($model, 'round')->textInput() //*?>

    <?= $form->field($model, 'sets')->textInput() ?>

    <?= $form->field($model, 'scores')->textInput(['value'=>'s'.time()]) ?>

    <?= $form->field($model, 'win_loss')->dropDownList([ '1' => '胜', '-1' => '负', '0' => '平', ]) ?>

    <?= $form->field($model, 'player_point')->textInput() ?>

    <?= $form->field($model, 'opponent_point')->textInput() ?>

    <?= $form->field($model, 'player_challenger')->checkbox() ?>

    <?= $form->field($model, 'opponent_challenger')->checkbox() ?>

    <?= $form->field($model, 'player_quit')->checkbox() ?>

    <?= $form->field($model, 'opponent_quit')->checkbox() ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <?= MyFunction::timeForm($model)?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
