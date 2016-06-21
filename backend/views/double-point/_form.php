<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
use common\models\AwTeam;
use common\models\AwPlayerInformation;
/* @var $this yii\web\View */
/* @var $model common\models\AwDoublePoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-double-point-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $teams=AwTeam::find()->all();
//    var_dump($teams);
    $datas=array();
    foreach ($teams as $team){
        $players=$team->player->name.'&'.$team->player0->name;
        $datas=$datas+array($team->id=>$players);
    }
    echo $form->field($model, 'team')->dropDownList($datas);
    ?>

    <?= $form->field($model, 'year')->textInput(['value' => date('Y')]) ?>

    <?= $form->field($model, 'week')->textInput(['value' => date('W')]) ?>

    <?= $form->field($model, 'total_matches')->textInput() ?>

    <?= $form->field($model, 'win_matches')->textInput() ?>

    <?= $form->field($model, 'margin_bureau')->textInput() ?>

    <?= $form->field($model, 'point')->textInput() ?>

    <?= MyFunction::timeForm($model) ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
