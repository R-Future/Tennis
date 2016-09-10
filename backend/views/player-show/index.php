<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/14
 * Time: 21:47
 */

/**
 * @var $players array
 */

$this->title='球员个人信息';
//$this->registerCssFile('@web/css/table-center.css');
$this->registerCssFile('@web/css/player-show.css');
$this->registerCssFile('../../common/css/base.css');
?>
<div class="form-group">
    <div class="col-lg-offset-4 col-xs-2">
        <select id="player" class="form-control">
            <?php foreach($players as $index => $player):?>
                <option id="<?=$index?>"><?=$player?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-xs-2 text-center">
        <button id="submit" class="btn btn-success" type="button">查看个人信息</button>
    </div>
</div>
<!--<div class="form-group">-->
    <div id="detail"></div>
<!--</div>-->

<script type="text/javascript">
    $(function () {
        $("#submit").on('click',function () {
            $.ajax({
                url: "<?= Yii::$app->urlManager->createUrl(['player-show/detail'])?>"+"&id="+$("#player").find("option:selected").attr('id'),
                type: "get",
                cache: true,
                dataType: "html",
                success:function (data) {
                    $("#detail").html(data);
                }
            })
        })
    })
</script>