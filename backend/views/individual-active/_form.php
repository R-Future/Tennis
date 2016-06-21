<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\base\MyFunction;
use common\models\AwPlayerInformation;
use common\models\AwActive;
/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualActive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aw-individual-active-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'player')->dropDownList(AwPlayerInformation::find()->select('name')->indexBy('id')->column())?>

    <?php 
    $actives=AwActive::find()->all();
    $datas=array();
    foreach ($actives as $active){
        $place=$active->place0->name;
        $datas=$datas+array($active->id=>$active->time.' '.$place.' '.$active->active);
    }
    echo $form->field($model, 'active')->dropDownList($datas);
    ?>

    <?= MyFunction::timeForm($model)?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_invalidated')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
