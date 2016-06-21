<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/21
 * Time: 15:13
 */

/**
 * @doubles_match common\models\AwDoublesMatch
 * @match_scores common\models\AwMatchScore
 * @alert string
 */

use common\models\AwTournament;
use common\models\AwArena;
use common\base\MyFunction;
use common\models\AwPlayerInformation;
use common\models\AwTeam;
use common\models\AwSinglePoint;
use common\models\AwPointType;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$tournaments=AwTournament::find()->select(['id','name'])->asArray()->all();
$match_places=AwArena::find()->select(['id','name'])->asArray()->all();
$teams=Awteam::find()->all();
foreach($teams as $team){
    $player1=AwPlayerInformation::find()->select(['name'])->where(['id'=>$team->player1])->one();
    $player2=AwPlayerInformation::find()->select(['name'])->where(['id'=>$team->player2])->one();
    $name=$player1['name']."&".$player2['name'];
    $t[]=['id'=>$team->id,'name'=>$name];
}
//$s=[];
//for($i=0;$i<2;$i++) $s=array(1,0);
//$player=AwTeam::findOne(['id'=>2]);
//var_dump($player->player1);
$this->title="记录双打比赛";
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
            <?= $form->field($doubles_match,'tournament')->dropDownList(\yii\helpers\ArrayHelper::map($tournaments,'id','name'))?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <!--                场地类型-->
            <?= $form->field($doubles_match,'field_type')->dropDownList(['硬地'=>'硬地','红土'=>'红土','草地'=>'草地'])?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <!--                参赛项目-->
            <?= $form->field($doubles_match,'entry_project')->dropDownList(['混双'=>'混双','男双'=>'男双','女双'=>'女双'])?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <!--                比赛地点-->
            <?= $form->field($doubles_match,'match_place')->dropDownList(AwArena::find()->select(['name','id'])->indexBy('id')->column())?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <!--                比赛时间-->
            <?= $form->field($doubles_match,'match_time')->textInput(['value'=>MyFunction::getCurrentDate()])?>
        </div>
        <div class="col-lg-offset-1 col-xs-2">
            <!--                盘数-->
            <?= $form->field($doubles_match,'sets')->dropDownList(['1'=>'1','3'=>'3','5'=>'5'])?>
        </div>
    </div>

    <hr>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-8">
            <?= $form->field($doubles_match,'round')->textInput()?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
            <!--player1-->
            <?= $form->field($doubles_match,'team1')->dropDownList(\yii\helpers\ArrayHelper::map($t,'id','name'))?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
            <!--player2-->
            <?= $form->field($doubles_match,'team2')->dropDownList(\yii\helpers\ArrayHelper::map($t,'id','name'))?>
        </div>
    </div>

    <?php foreach ($match_scores as $index => $match_score):?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-xs-1">
                <?= $form->field($match_score,"[$index]set")->textInput(['value'=>$index+1])?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($match_score,"[$index]player1_score")->textInput()?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($match_score,"[$index]tie_player1_score")->textInput()?>
            </div>
            <div class="col-lg-offset-2 col-xs-2">
                <?= $form->field($match_score,"[$index]player2_score")->textInput()?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($match_score,"[$index]tie_player2_score")->textInput()?>
            </div>
        </div>
    <?php endforeach;?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-2">
            <?= $form->field($doubles_match,'team1_quit')->checkbox()?>
        </div>
        <div class="col-lg-offset-3 col-xs-2">
            <?= $form->field($doubles_match,'team2_quit')->checkbox()?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-10">
            <?= $form->field($doubles_match,'is_invalidated')->checkbox()?>
        </div>
        <div class="col-lg-offset-2 col-xs-8">
            <?= $form->field($doubles_match, 'comment')->textarea()?>
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
    $("#awdoublesmatch-team1").on('blur',function(){
        if($("#awdoublesmatch-team1").val()==$('#awdoublesmatch-team2').val()){
            alert('比赛双方不能是同一组!');
        }
    });
    $("#awdoublesmatch-team2").on('blur',function(){
        if($("#awdoublesmatch-team1").val()==$('#awdoublesmatch-team2').val()){
            alert('比赛双方不能是同一组!');
        }
    });
})
JS;
$this->registerJs($js);
?>