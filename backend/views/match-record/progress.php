<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/8/30
 * Time: 22:09
 */
/**
 * @var $max
 * @var $now
 */
?>
<div class="progress">
    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="<?= $max?>" aria-valuenow="<?= $now?>" style="min-width: 2em;width: <?= (round($now/$max,2)*100).'%'?>">
        <?= '已完成'.(round($now/$max,2)*100).'%'?>
    </div>
</div>
