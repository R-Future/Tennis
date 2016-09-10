<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/21
 * Time: 15:13
 */

/**
 * @var $doubles_matches common\models\AwDoublesMatch
 * @var $match_scores common\models\AwMatchScore
 * @var $alert string
 */

use common\models\AwTournament;
use common\models\AwArena;
use common\base\MyFunction;
use common\models\AwDoublesMatch;
use common\models\AwPointType;
use common\models\AwMatchScore;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use dosamigos\datepicker\DatePicker;

//$s=[];
//for($i=0;$i<2;$i++) $s=array(1,0);
//$player=AwTeam::findOne(['id'=>2]);
//var_dump($player->player1);
$this->registerCssFile("../../common/css/base.css");
$this->registerCssFile("../../common/css/loaders.css");
$this->title="记录双打比赛";
?>
<div class="row">
    <?php $form=ActiveForm::begin([
        'id' => 'doubles_match',
        'options' => ['class' => 'form-horizontal'],
    ]);?>
    <!--提醒信息保存成功-->
    <?php if(!is_null($alert)):?>
        <div class="form-group">
            <div class="col-lg-offset-2 col-xs-8 text-success">
                <?= $alert?>
            </div>
        </div>
    <?php endif;?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-3">
            <!--               赛事类型-->
            <?= $form->field($doubles_matches[0],'[0]tournament')->dropDownList(AwTournament::find()->select('name')->indexBy('id')->column(),
                [
                    'prompt'=>'--请选择赛事类型--',
                    'onchange'=>'
                        $.post("'.Yii::$app->urlManager->createUrl(['match-record/round']).'&tournament_id="+$(this).val(), function(data){
                            $("select#awdoublesmatch-0-round").html(data);
                        })'
                ])?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
            <!--                场地类型-->
            <?= $form->field($doubles_matches[0],'[0]field_type')->dropDownList(['硬地'=>'硬地','红土'=>'红土','草地'=>'草地'],['prompt'=>'--请选择场地类型--'])?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-3">
            <!--                比赛地点-->
            <?= $form->field($doubles_matches[0],'[0]match_place')->dropDownList(AwArena::find()->select(['name','id'])->indexBy('id')->column(),['prompt'=>'--请选择比赛地点--'])?>
        </div>
        <div class="col-lg-offset-2 col-xs-3">
            <!--                比赛时间-->
            <?= $form->field($doubles_matches[0],'[0]match_time')->widget(DatePicker::className(),[
                'language'=>'zh-CN',
                'options'=>['value'=>MyFunction::getCurrentDate()],
                //'inline'=>true,
                'template' => '{addon}{input}',
                'clientOptions'=>[
                    'autoclose'=>true,
                    'format'=>'yyyy-mm-dd',
                ]
            ])?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-xs-8">
            <?= $form->field($doubles_matches[0],'[0]round')->dropDownList((new AwPointType())->getRoundList($doubles_matches[0]->tournament),['prompt'=>'--请选择轮次--'])?>
        </div>
        <div class="col-lg-offset-2 col-xs-8">
            <!--                盘数-->
            <?= $form->field($doubles_matches[0],'[0]sets')->dropDownList(['1'=>'1','3'=>'3','5'=>'5'],['prompt'=>'--请选择盘数--'])?>
        </div>
    </div>

    <hr>

    <div id="doubles-record" class="form-group-sm">
        <div class="form-group">
            <span onclick="addMatch($(this))" id="add_match_record" class="glyphicon glyphicon-plus col-lg-offset-2 col-sm-1 btn btn-info" title="添加记录"></span>
        </div>

        <table class="table-bordered table-responsive">
            <thead>
            <tr>
                <th class="width-20 text-align-center">#</th>
                <th class="col-xs-2">组合</th>
                <th class="col-xs-1">盘次</th>
                <th class="col-xs-1">比分</th>
                <th class="col-xs-1">抢七</th>
                <th class="col-xs-1">退赛</th>
                <th class="col-xs-4">备注</th>
                <th class="text-align-center">操作</th>
            </tr>
            </thead>
            <?php foreach ($doubles_matches as $id => $doubles_match) {
                echo $this->render("_doublesForm",['doubles_match'=>$doubles_match,'id'=>$id,'match_score'=>$match_scores[$id],'form'=>$form]);
            }?>
        </table>
    </div>

    <div class="form-group">
        <?= Html::submitButton('提交',['id'=>'btnDoubles','class' => 'btn btn-primary col-lg-offset-9 col-xs-1','data-toggle'=>'modal','data-target'=>'#loaderModal'])?>
    </div>

    <?php ActiveForm::end();?>

</div><!--end of row-->

<script language="javascript" type="text/javascript">
    var newDoublesMatch=new String(<?= Json::htmlEncode($this->render('_doublesForm',['id'=>'idrep','doubles_match'=>new AwDoublesMatch(),'match_score'=> [new AwMatchScore()],'form'=>$form]),true)?>);
    function addMatch(button) {
        var id=$("tbody").length;
        button.parents("div#doubles-record").children("table").append(newDoublesMatch.replace(/idrep/g,id.toString()));
    }
    function deleteMatch(button) {
        button.parents("tbody").detach();
    }
</script>
<!--modal-->
<div class="modal fade" id="loaderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="loader-inner ball-triangle-path">
            <div style="background-color: white;"></div>
            <div style="background-color: white;"></div>
            <div style="background-color: white;"></div>
        </div>
    </div>
</div>