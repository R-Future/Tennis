<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/29
 * Time: 20:24
 */
use yii\helpers\Html;

/**
 * @var $records array
 * @var $player1_win integer
 * @var $player2_win integer
 */

//var_dump($records);
echo Html::cssFile('@web/css/table-center.css');
?>
<?php if(empty($records)):?>
    <div class="col-lg-offset-5 col-xs-2 text-center">
        <?= '无交手纪录'?>
    </div>
<?php endif;?>
<?php if(!empty($records)):?>
<div class="form-group col-xs-12">
    <div class="col-lg-offset-2 col-xs-3 text-center"><?= $player1_win."(".(number_format($player1_win/($player1_win+$player2_win)*100,2))."%)"?></div>
    <div class="col-xs-2 text-center">vs</div>
    <div class="col-xs-3 text-center"><?= $player2_win."(".(number_format($player2_win/($player1_win+$player2_win)*100,2))."%)"?></div>
</div>
<div class="form-group col-lg-offset-2 col-xs-8">
    <table class="table table-striped">
        <thead>
        <tr>
<!--            <th>胜负</th>-->
            <th>比赛时间</th>
            <th>赛事名称</th>
            <th>场地类型</th>
            <th>Round</th>
            <th>VS</th>
            <th>比分</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($records as $record):?>
        <tr>
<!--            <td style="color:--><?php //if($record['win_loss']==-1) echo 'red';else echo 'green'?><!--">--><?php //if($record['win_loss']==1) echo 'win';elseif($record['win_loss']==-1) echo 'loss';?><!--</td>-->
            <td><?=$record['match_time']?></td>
            <td><?=$record['name']?></td>
            <td><?=$record['field_type']?></td>
            <td><?php switch($record['round']){
                    case 0:echo '小组赛';break;
                    case 2:echo '决赛';break;
                    case 4:echo '半决赛';break;
                    default: echo '1/'.$record['round'];
                };?></td>
            <td><?=$record['versus']?></td>
            <td><?=$record['score_str']?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<? endif;?>