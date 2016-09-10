<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/8/20
 * Time: 0:01
 */

use common\models\AwPlayerInformation;
/**
 * @var $singles_match
 * @var $match_score
 * @var $id
 * @var $form
 */
?>

<tbody>
    <tr>
        <td class="width-20 text-align-center" id="number<?= $id?>" rowspan="2"><?= $id?></td>
        <td class="height-20 col-xs-2"><?= $form->field($singles_match,"[$id]player")->dropDownList(AwPlayerInformation::find()->select('name')->indexBy('id')->column(),['prompt'=>'-球员1-'])->label(false)?></td>
        <?php foreach($match_score as $index => $value):?>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]set")->textInput(['value'=>$index+1])->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]player1_score")->textInput()->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]tie_player1_score")->textInput()->label(false)?></td>
        <?php endforeach;?>
        <td class="col-xs-1"><?= $form->field($singles_match,"[$id]player_challenger")->checkbox()->label(false)?></td>
        <td class="col-xs-1"><?= $form->field($singles_match,"[$id]player_quit")->checkbox()->label(false)?></td>
        <td class="col-xs-4" rowspan="2"><?= $form->field($singles_match,"[$id]comment")->textarea()->label(false)?></td>
        <td class="text-align-center" rowspan="2"><span title="删除" class="glyphicon glyphicon-trash btn btn-link" onclick="deleteMatch($(this))"></span></td>
    </tr>
    <tr>
        <td class="col-xs-2"><?= $form->field($singles_match,"[$id]opponent")->dropDownList(AwPlayerInformation::find()->select('name')->indexBy('id')->column(),['prompt'=>'-球员2-'])->label(false)?></td>
        <?php foreach($match_score as $index => $value):?>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]set")->textInput(['value'=>$index+1])->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]player2_score")->textInput()->label(false)?></td>
            <td class="col-xs-1"><?= $form->field($value,"[$id][$index]tie_player2_score")->textInput()->label(false)?></td>
        <?php endforeach;?>
        <td class="col-xs-1"><?= $form->field($singles_match,"[$id]opponent_challenger")->checkbox()->label(false)?></td>
        <td class="col-xs-1"><?= $form->field($singles_match,"[$id]opponent_quit")->checkbox()->label(false)?></td>
    </tr>
</tbody>

<?php
$js = <<< JS
$(document).ready(function(){
    $("button#btnSingles").on('mouseover',function(){
        var number=$("tbody").length;
        for(var i=0;i<number;i++){
            var player_id="#awsinglesmatch-"+i+"-player";
            var opponent_id="#awsinglesmatch-"+i+"-opponent";
            if($(player_id).val().trim()==""){
                $(player_id).css("background","tomato");
                alert('请选择比赛选手!');
                $(player_id).css("background","white");
                break;
            }else if($(opponent_id).val().trim()==""){
                $(opponent_id).css("background","tomato");
                alert('请选择比赛选手!');
                $(opponent_id).css("background","white");
                break;
            }else if($(player_id).val().trim()==$(opponent_id).val().trim()){
                $(player_id).css("background","tomato");
                $(opponent_id).css("background","tomato");
                alert('比赛双方不能是同一人!');
                $(player_id).css("background","white");
                $(opponent_id).css("background","white");
                break;
            }
        }
    });
    
})
JS;
$this->registerJs($js);
?>