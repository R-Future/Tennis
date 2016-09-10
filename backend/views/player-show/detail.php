<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/14
 * Time: 22:04
 */
use common\base\MyFunction;
/**
 * @var $player
 * @var $rank
 * @var $actives
 * @var $singles
 * @var $doubles
 */

//var_dump($player);
//var_dump($rank);
//var_dump($actives);
//var_dump($singles);
//var_dump($doubles);

//$this->registerCssFile('@web/css/player-show.css');
//$arrEntryType=array_flip(MyFunction::EntryProject());
?>
<div class="player-information">

    <div class="head-sculpture">
        <div class="image">
            <h3 class="name"><?=$player['name']?></h3>
            <img src="../../common/imgs/no-picture.jpg" alt="头像">

        </div>

        <div class="rank-information">
            <?php if(!empty($rank)):?>
                <div>当前排名:<?= $rank['current_rank']?></div>
                <div>最高排名:<?= $rank['highest_rank']?></div>
                <?php if($rank['highest_rank']==1):?>
                    <div>第一总周数:<?=$rank['no1_weeks']?></div>
                    <div>连续第一最长周数:<?=$rank['longest_no1_weeks']?></div>
                <?php endif;?>
                <div>当前积分:<?= $rank['total_points']?></div>
            <?php endif;?>
        </div>
    </div>

    <div class="basic-information col-xs-4">
        <table class="table table-striped">
            <tbody>
            <tr>
                <td class="font-bold">性别:</td>
                <td><?=$player['gender']?></td>
                <td class="font-bold">正手:</td>
                <td><?=$player['forehand']?></td>
            </tr>
            <tr>
                <td class="font-bold">身高:</td>
                <td><?=$player['height']?>cm</td>
                <td class="font-bold">反手:</td>
                <td><?=$player['backhand']?></td>
            </tr>
            <tr>
                <td class="font-bold">体重:</td>
                <td><?=$player['weight']?>kg</td>
                <td class="font-bold">级别:</td>
                <td><?=$player['grade']?></td>
            </tr>
            <tr>
                <td class="font-bold">年龄:</td>
                <td><?=$player['age']?></td>
                <td class="font-bold">球龄:</td>
                <td><?=$player['playing_years']?></td>

            </tr>
            <tr>
                <td class="font-bold">单打冠军数:</td>
                <td><?=$player['singles_titles']?></td>
                <td class="font-bold">双打冠军数:</td>
                <td><?=$player['doubles_titles']?></td>
            </tr>
            <tr>
                <td class="font-bold">组别:</td>
                <td><?=$player['group']?></td>
                <td class="font-bold">退役:</td>
                <td><?= $player['retired']? '是':'否'?></td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <?php if(!empty($singles)):?>
        <div class="active-record">
            <label for="">参加单打比赛<?= count($singles)?>场</label>
            <div class="record col-xs-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>地点</th>
                        <th>参赛项目</th>
                        <th>场地类型</th>
                        <th>赛事类型</th>
                        <th>ROUND</th>
                        <th>比分</th>
                        <th>对手</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($singles as $single):?>
                        <tr>
                            <td><?=$single->match_time?></td>
                            <td><?=$single->matchPlace->name?></td>
                            <td><?=MyFunction::EntryProject_flip()[$single->entry_project]?></td>
                            <td><?=$single->field_type?></td>
                            <td><?=$single->tournament0->name?></td>
                            <td><?= $single->round==0? '小组赛':$single->round.'强'?></td>
                            <td>
                                <?php
                                foreach ($single->matchScores as $score) {
                                    echo is_null($score->tie_player1_score) ? $score->player1_score . ':' . $score->player2_score :
                                        $score->player1_score . '(' . $score->tie_player1_score . '):' . $score->player2_score . '(' . $score->tie_player2_score . ')';
                                    echo " ";
                                }
                                ?>
                            </td>
                            <td><?=$single->opponent0->name?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif;?>

    <?php if(!empty($doubles)):?>
        <div class="active-record">
            <label for="">参加双打比赛<?= count($doubles)?>场</label>
            <div class="record col-xs-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>地点</th>
                        <th>参赛项目</th>
                        <th>场地类型</th>
                        <th>赛事类型</th>
                        <th>ROUND</th>
                        <th>队友</th>
                        <th>比分</th>
                        <th>对手</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($doubles as $double):?>
                    <tr>
                        <td><?=$double->match_time?></td>
                        <td><?=$double->matchPlace->name?></td>
                        <td><?=MyFunction::EntryProject_flip()[$double->entry_project]?></td>
                        <td><?=$double->field_type?></td>
                        <td><?=$double->tournament0->name?></td>
                        <td><?=$double->round==0? '小组赛':$double->round.'强'?></td>
                        <td><?=$double->team10->player0->name?></td>
                        <td>
                            <?php
                            foreach ($double->matchScores as $score) {
                                echo is_null($score->tie_player1_score) ? $score->player1_score . ':' . $score->player2_score :
                                    $score->player1_score . '(' . $score->tie_player1_score . '):' . $score->player2_score . '(' . $score->tie_player2_score . ')';
                                echo " ";
                            }
                            ?>
                        </td>
                        <td><?=$double->team20->player->name.'&'.$double->team20->player0->name?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif;?>

    <?php if(!empty($actives)):?>
        <div class="active-record">
            <label for="">参加活动<?= count($actives)?>次</label>
            <div class="record col-xs-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>地点</th>
                        <th>活动内容</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($actives as $active):?>
                    <tr>
                        <td><?= $active['time']?></td>
                        <td><?= $active['place']?></td>
                        <td><?= $active['active']?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif;?>

</div>
