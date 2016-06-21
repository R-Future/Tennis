<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/21
 * Time: 10:44
 */
use common\models\AwTournament;
use common\models\AwArena;
use common\base\MyFunction;
use common\models\AwPlayerInformation;
use common\models\AwSinglePoint;
use common\models\AwPointType;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $singlesmatch common\models\AwSinglesMatch
 * @var $matchscores common\models\AwMatchScore
 * @var $alert
 */

$tournaments=AwTournament::find()->select(['id','name'])->asArray()->all();
$match_places=AwArena::find()->select(['id','name'])->asArray()->all();
$players=AwPlayerInformation::find()->select(['id','name','gender'])->asArray()->all();
// $points[0]=new AwSinglePoint();
// $points[1]=new AwSinglePoint();
//for($i=0;$i<2;$i++){
//    $points[]=AwSinglePoint::findOne(['player'=>$i,'year'=>2016,'week'=>24]);
//}
//foreach($points as $index => $point){
//   var_dump($point);
//}
$this->title="记录单打比赛";
?>
<div class="container">
    <?php $form=ActiveForm::begin([
        'id' => 'singles_match',
         'options' => ['class' => 'form-horizontal'],
    ]);?>
<!--提醒信息保存成功-->
    <?php if(!is_null($alert)):?>
        <div class="form-group">
            <div class="col-lg-offset-2 col-xs-3 text-success">
                <?= $alert?>
            </div>
        </div>
    <?php endif;?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
<!--               赛事类型-->
            <?= $form->field($singlesmatch,'tournament')->dropDownList(\yii\helpers\ArrayHelper::map($tournaments,'id','name'))?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
<!--                场地类型-->
            <?= $form->field($singlesmatch,'field_type')->dropDownList(['硬地'=>'硬地','红土'=>'红土','草地'=>'草地'])?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
<!--                参赛项目-->
            <?= $form->field($singlesmatch,'entry_project')->dropDownList(['混单'=>'混单','男单'=>'男单','女单'=>'女单'])?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
<!--                比赛地点-->
            <?= $form->field($singlesmatch,'match_place')->dropDownList(AwArena::find()->select(['name','id'])->indexBy('id')->column())?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
<!--                比赛时间-->
            <?= $form->field($singlesmatch,'match_time')->textInput(['value'=>MyFunction::getCurrentDate()])?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
<!--                盘数-->
            <?= $form->field($singlesmatch,'sets')->dropDownList(['1'=>'1','3'=>'3','5'=>'5'])?>
        </div>
    </div>

    <hr>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-8">
            <?= $form->field($singlesmatch,'round')->textInput()?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
<!--                player1-->
            <?= $form->field($singlesmatch,'player')->dropDownList(AwPlayerInformation::find()->select(['name','id'])->indexBy('id')->column())?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
<!--                player2-->
            <?= $form->field($singlesmatch,'opponent')->dropDownList(AwPlayerInformation::find()->select(['name','id'])->indexBy('id')->column())?>
        </div>
    </div>

    <?php foreach($matchscores as $index => $value):?>

        <div class="form-group">
<!--            盘次-->
            <div class="col-lg-offset-1 col-xs-1">
                <?= $form->field($value,"[$index]set")->textInput(['value'=>$index+1])?>
            </div>

<!--            比分-->
            <div class="col-xs-2">
                <?= $form->field($value,"[$index]player1_score")->textInput()?>
            </div>
            <div class="col-xs-1"><!--tiebreak-->
                <?= $form->field($value,"[$index]tie_player1_score")->textInput()?>
            </div>
            <div class="col-lg-offset-2 col-xs-2">
                <?= $form->field($value,"[$index]player2_score")->textInput()?>
            </div>
            <div class="col-xs-1"><!--tiebreak-->
                <?= $form->field($value,"[$index]tie_player2_score")->textInput()?>
            </div>
        </div>
    <?php endforeach?>

<!--        退赛记录-->
    <div class="form-group form-inline">
        <div class="col-lg-offset-2 col-xs-3">
            <?= $form->field($singlesmatch,'player_quit')->checkbox()?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
            <?= $form->field($singlesmatch,'opponent_quit')->checkbox()?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-10">
            <?= $form->field($singlesmatch,'is_invalidated')->checkbox()?>
        </div>
        <div class="col-lg-offset-2 col-xs-8">
            <?= $form->field($singlesmatch,'comment')->textarea()?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('提交',['class' => 'btn btn-primary col-lg-offset-2 col-xs-8'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
<?php
$js = <<< JS
$(function() {
    $("#awsinglesmatch-opponent").on('blur',function(){
        if($("#awsinglesmatch-player").val()==$('#awsinglesmatch-opponent').val()){
            alert('比赛双方不能是同一人!');
        }
    });
    $("#awsinglesmatch-player").on('blur',function(){
        if($("#awsinglesmatch-player").val()==$('#awsinglesmatch-opponent').val()){
            alert('比赛双方不能是同一人!');
        }
    });
})
JS;
$this->registerJs($js);
?>