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

$this->title="scrappy";
?>
<form class="form-inline col-lg-offset-2 col-xs-8">
    <div id="alert" class="form-group" style="color:red;">
        <?php if(isset($alert)) echo $alert;?>
    </div>
    <fieldset>
        <legend>退赛扣分<span style="color:red;">（务必当周完成扣分!）</span></legend>
        <div class="form-group">
            <label for="entry_project">参赛项目</label>
            <select id="entry_project" class="form-control">
                <option value="">--请选择参赛项目--</option>
                <option value="混单">混单</option>
                <option value="女单">女单</option>
                <option value="男单">男单</option>
            </select>
        </div>
        <div class="form-group">
            <label for="players">球员</label>
            <select id="players" class="form-control">
                <option value="">--请选择球员--</option>
            </select>
        </div>

        <div class="form-group">
            <label for="point">需扣分数</label>
            <input id="point" type="text" class="form-control">
        </div>
        <button type="button" id="btn-penalty" class="btn btn-success">确定</button>
    </fieldset>
    <fieldset>
        <legend>金银组调整</legend>
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
            if($("#point").val()==''){
                alert('请输入要扣除的积分');
            }else{
                $.ajax({
                    url: "<?= Yii::$app->urlManager->createUrl(['scrappy/index'])?>",
                    type: "post",
                    dataType: "text",
                    data: {entry_project:$("#entry_project").val(),player_id:$("#players").find("option:selected").attr('id'),point:$("#point").val()},
                    success:function (data) {
                        $("#alert").html(data);
                    }
                });
            }
        });
        $("#btn-adjust").on('click',function () {
           if($("#number").val()==''){
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
                    $("#players").html(data);
                }
            })
        })
    })
</script>