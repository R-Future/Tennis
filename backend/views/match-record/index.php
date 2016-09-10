<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/8/28
 * Time: 12:05
 */
$this->title="比赛记录";
?>

<div class="row">
    <div class="">
        <h4 id="singles" class="btn btn-link">单打比赛</h4>
        <h4 id="doubles" class="btn btn-link">双打比赛</h4>
    </div>
    <hr>
    <div id="content" class=""></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#singles").on("click",function() {
            //$("div#content").html(<?= \yii\helpers\Json::htmlEncode($this->render("_singles"))?>);
        });
        $("#doubles").on("click",function () {
            //$("div#content").html(<?= \yii\helpers\Json::htmlEncode($this->render("_doubles"))?>);
        })
    })
</script>