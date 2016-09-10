<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/15
 * Time: 19:43
 */
/**
 * @var $players array
 * @var $alert
 */
use common\base\MyFunction;
use dosamigos\datepicker\DatePicker;
const MIXED='混单';
const DOUBLES='双打';
const WOMEN_SINGLE='女单';
const MEN_SINGLE='男单';
const DOUBLES_INDIVIDUAL="双打个人";
const MEN_DOUBLE='男双';
const WOMEN_DOUBLE='女双';
const MIXED_DOUBLE='混双';
$this->title="scrappy";
?>
<form class="col-lg-offset-2 col-xs-8">
    <div id="alert" class="form-group" style="color:red;">
        <?php if(isset($alert)) echo $alert;?>
    </div>
    <fieldset>
        <legend style="color: tomato;">退赛扣分</legend>
        <div class="form-group">
            <label for="quit_time">退赛时间</label>
            <?= DatePicker::widget([
                'language'=>'zh-CN',
                'name'=>'quit_time',
                'id'=>'quit_time',
                'attribute'=>'date',
                'value'=>MyFunction::getCurrentDate(),
                'template'=>'{addon}{input}',
                'clientOptions'=>[
                    'autoclose'=>true,
                    'format'=>'yyyy-mm-dd'
                ]
            ])?>
        </div>

        <div class="form-group">
            <label for="entry_project">参赛项目</label>
            <select id="entry_project" class="form-control">
                <option value="">--请选择参赛项目--</option>
                <option value="<?=MyFunction::EntryProject()[MIXED]?>">混单</option>
                <option value="<?=MyFunction::EntryProject()[WOMEN_SINGLE]?>">女单</option>
                <option value="<?=MyFunction::EntryProject()[MEN_SINGLE]?>">男单</option>
                <option value="<?=MyFunction::EntryProject()[DOUBLES_INDIVIDUAL]?>">双打个人</option>
<!--                <option value="--><?//=MyFunction::EntryProject()[MEN_DOUBLE]?><!--">男双</option>-->
<!--                <option value="--><?//=MyFunction::EntryProject()[WOMEN_DOUBLE]?><!--">女双</option>-->
<!--                <option value="--><?//=MyFunction::EntryProject()[MIXED_DOUBLE]?><!--">混双</option>-->
<!--                <option value="--><?//=MyFunction::EntryProject()[DOUBLES]?><!--">双打</option>-->
            </select>
        </div>

        <div class="form-group">
            <label for="player">球员</label>
            <select id="player" class="form-control">
                <option value="">--请选择球员--</option>
            </select>
        </div>

        <div class="form-group">
            <label for="point">需扣分数</label>
            <input id="point" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="comment">备注</label>
            <input id="comment" type="text" class="form-control">
        </div>

        <div class="form-group">
            <button type="button" id="btn-penalty" class="btn btn-success">确定</button>
        </div>

    </fieldset>

    <fieldset>
        <legend style="color: tomato;">金银组调整</legend>
        <div class="form-group">
            <label for="number">调整人数</label>
            <input id="number" type="text" class="form-control">
        </div>
        <button type="button" id="btn-adjust" class="btn btn-success">确定</button>
    </fieldset>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btn-penalty").on('click',function () {
            if($("input#point").val()==''){
                alert('请输入要扣除的积分');
            }else{
                $.ajax({
                    url: "<?= Yii::$app->urlManager->createUrl(['scrappy/index'])?>",
                    type: "post",
                    dataType: "text",
                    data: {entry_project:$("#entry_project").val(),player_id:$("#player").find("option:selected").attr('id'),point:$("#point").val(),quit_time:$("#quit_time").val(),comment:$("#comment").val()},
                    success:function (data) {
                        $("#alert").html(data);
                    }
                });
            }
        });
        $("#btn-adjust").on('click',function () {
           if($("input#number").val()==''){
               alert('请输入要调整的人数');
           }else{
               $.ajax({
                   url: "<?= Yii::$app->urlManager->createUrl(['scrappy/adjust'])?>",
                   type: "post",
                   dataType: "text",
                   data:{number:$("#number").val()},
                   success:function (data) {
                       $("#alert").html(data);
                   }
               });
           }
        });
        $("#entry_project").on('change',function () {
            $.ajax({
                url: "<?= Yii::$app->urlManager->createUrl(['scrappy/player-list'])?>",
                type: "post",
                dataType: "html",
                data:{entry_type:$(this).val()},
                success:function (data) {
                    $("#player").html(data);
                }
            })
        })
    })
</script>