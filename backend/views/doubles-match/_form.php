<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
use common\models\AwTeam;
use common\models\AwArena;
use common\models\AwTournament;
/* @var $this yii\web\View */
/* @var $model common\models\AwDoublesMatch */
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

<div class="aw-doubles-match-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $teams=AwTeam::find()->all();
    $datas=array();
    foreach ($teams as $team){
        $players=$team->player->name.'&'.$team->player0->name;
        $datas=$datas+array($team->id=>$players);
    }
    echo $form->field($model, 'team1')->dropDownList($datas);
    echo $form->field($model, 'team2')->dropDownList($datas);
    ?>

    <?= $form->field($model, 'match_time')->textInput(['value'=>MyFunction::getCurrentDate()]) ?>

    <?= $form->field($model, 'match_place')->dropDownList(AwArena::find()->select('name')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'entry_project')->dropDownList([ '5' => '混双', '4' => '女双', '3' => '男双', ]) ?>

    <?= $form->field($model, 'field_type')->dropDownList([ '硬地' => '硬地', '红土' => '红土', '草地' => '草地',  ]) ?>

    <?= $form->field($model, 'tournament')->dropDownList(AwTournament::find()->select('name')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'round')->textInput() ?>

    <?= $form->field($model, 'sets')->textInput() ?>

    <?= $form->field($model, 'scores')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'win_loss')->dropDownList([ '1' => '胜', '-1' => '负', '0' => '平',  ]) ?>

    <?= $form->field($model, 'team1_point')->textInput() ?>

    <?= $form->field($model, 'team2_point')->textInput() ?>

    <?= $form->field($model, 'team1_quit')->checkbox() ?>

    <?= $form->field($model, 'team2_quit')->checkbox() ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <?= MyFunction::timeForm($model)?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
