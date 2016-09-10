<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/8/28
 * Time: 22:12
 */

use common\models\AwPlayerInformation;
use common\models\AwTeam;
/**
 * @var $doubles_match
 * @var $match_score
 * @var $id
 * @var $form
 */

$teams=AwTeam::find()->all();
$t=array();
foreach($teams as $team){
    $player1=AwPlayerInformation::find()->select(['name'])->where(['id'=>$team["player1"]])->one();
    $player2=AwPlayerInformation::find()->select(['name'])->where(['id'=>$team["player2"]])->one();
    $name=$player1['name']."&".$player2['name'];
    $t[]=['id'=>$team["id"],'name'=>$name];
}
?>

<tbody>
    <tr>
        <td class="width-20 text-align-center" id="number" rowspan="2"><?= $id?></td>
        <td class="height-20 col-xs-2"><?= $form->field($doubles_match,"[$id]team1")->dropDownList(\yii\helpers\ArrayHelper::map($t,'id','name'),["prompt"=>"-请选择-"])->label(false)?></td>
        <?php foreach($match_score as $index => $value):?>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]set")->textInput(['value'=>$index+1])->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]player1_score")->textInput()->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]tie_player1_score")->textInput()->label(false)?></td>
        <?php endforeach;?>
        <td class="col-xs-1"><?= $form->field($doubles_match,"[$id]team1_quit")->checkbox()->label(false)?></td>
        <td class="col-xs-4" rowspan="2"><?= $form->field($doubles_match,"[$id]comment")->textarea()->label(false)?></td>
        <td class="text-align-center" rowspan="2"><span title="删除" class="glyphicon glyphicon-trash btn btn-link" onclick="deleteMatch($(this))"></span></td>
    </tr>
    <tr>
        <td class="col-xs-2"><?= $form->field($doubles_match,"[$id]team2")->dropDownList(\yii\helpers\ArrayHelper::map($t,'id','name'),["prompt"=>"-请选择-"])->label(false)?></td>
        <?php foreach($match_score as $index => $value):?>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]set")->textInput(['value'=>$index+1])->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]player2_score")->textInput()->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]tie_player2_score")->textInput()->label(false)?></td>
        <?php endforeach;?>
        <td class="col-xs-1"><?= $form->field($doubles_match,"[$id]team2_quit")->checkbox()->label(false)?></td>
    </tr>
</tbody>

<?php
$js = <<< JS
$(document).ready((function() {
    $("button#btnDoubles").on('mouseover',function(){
        var numberOfmatch=$("tbody").length;
        for(var i=0;i<numberOfmatch;i++){
            var team1_id="#awdoublesmatch-"+i+"-team1";
            var team2_id="#awdoublesmatch-"+i+"-team2";
            if($(team1_id).val().trim()==""){
                $(team1_id).css("background","tomato");
                alert("组合名称不能为空");
                $(team1_id).css("background","white");
                break;
            }else if($(team2_id).val().trim()==""){
                $(team2_id).css("background","tomato");
                alert("组合名称不能为空");
                $(team2_id).css("background","white");
                break;
            }else if($(team1_id).val().trim()==$(team2_id).val().trim()){
                $(team1_id).css("background","tomato");
                $(team2_id).css("background","tomato");
                alert("比赛双方不可为同一组合");
                $(team1_id).css("background","white");
                $(team2_id).css("background","white");
                break;
            }
        }
        
    }); 
}))
JS;
$this->registerJs($js);
?>