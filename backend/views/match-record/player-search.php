<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/29
 * Time: 12:20
 */
/**
 * @var $players array
 */

$this->title='H2H';
?>
<div class="container">
    <div class="form-group col-xs-12">
        <div class="col-lg-offset-2 col-xs-3">
            <!--            <label for="player1">player1</label>-->
            <select name="player1" id="player1" class="form-control">
                <?php foreach($players as $player):?>
                    <option id="<?=$player['id']?>"><?=$player['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-xs-2 text-center">
            <button class="btn btn-primary" type="button" id="submit">查询</button>
        </div>
        <div class="col-xs-3">
            <!--            <label for="player2">player2</label>-->
            <select name="player2" id="player2" class="form-control">
                <?php foreach($players as $player):?>
                    <option id="<?=$player['id']?>"><?=$player['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xl-12" id="h2h"></div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#submit").on("click", function () {
            if($("#player2").val()==$("#player1").val()){
                alert("对阵双方不可为同一人!");
            }else{
                $.ajax({
                    url: "<?= Yii::$app->urlManager->createUrl(['match-record/player-search'])?>",
                    type: "post",
                    cache: true,
                    data: {player1_name: $("#player1").val(),player2_name: $("#player2").val(),player1_id: $("#player1").find("option:selected").attr('id'),player2_id: $("#player2").find("option:selected").attr('id')},
                    dataType: "html",
                    success: function(data){
                        $("#h2h").html(data);//这里使用了html避免多次提交时旧数据依然存在，如若使用append则会出现此问题
                    }
                });
            }
        });
    });
</script>