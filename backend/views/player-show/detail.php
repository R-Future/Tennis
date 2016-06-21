<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/14
 * Time: 22:04
 */
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
?>
<div class="player-information">

    <div class="head-sculpture">
        <div class="image">
            <h3 class="name"><?=$player['name']?></h3>
            <img src="/advanced/common/imgs/no-picture.jpg" alt="头像">

        </div>

        <div class="rank-information">
            <?php if(!empty($rank)):?>
                <div>当前排名:<?= $rank['current_rank']?></div>
                <div>最高排名:<?= $rank['highest_rank']?></div>
                <div>当前积分:<?= $rank['total_points']?></div>
            <?php endif;?>
        </div>
    </div>

    <div class="basic-information col-xs-4">
        <table class="table table-striped">
            <tbody>
            <tr>
                <td>性别:</td>
                <td><?=$player['gender']?></td>
                <td>正手:</td>
                <td><?=$player['forehand']?></td>
            </tr>
            <tr>
                <td>身高:</td>
                <td><?=$player['height']?>cm</td>
                <td>反手:</td>
                <td><?=$player['backhand']?></td>
            </tr>
            <tr>
                <td>体重:</td>
                <td><?=$player['weight']?>kg</td>
                <td>级别:</td>
                <td><?=$player['grade']?></td>
            </tr>
            <tr>
                <td>年龄:</td>
                <td><?=$player['age']?></td>
                <td>球龄:</td>
                <td><?=$player['playing_years']?></td>

            </tr>
            <tr>
                <td>单打冠军数:</td>
                <td><?=$player['singles_titles']?></td>
                <td>双打冠军数:</td>
                <td><?=$player['doubles_titles']?></td>
            </tr>
            <tr>
                <td>组别:</td>
                <td><?=$player['group']?></td>
                <td>退役:</td>
                <td><?= $player['retired']=='no'? '否':'是'?></td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <?php if(!empty($singles)):?>
        <div class="singles-match">
            <label for="">参加单打比赛<?= count($singles)?>次</label>
            <div class="match-record col-xs-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>地点</th>
                        <th>参赛项目</th>
                        <th>场地类型</th>
                        <th>赛事类型</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($singles as $single):?>
                        <tr>
                            <td><?=$single->match_time?></td>
                            <td><?=$single->matchPlace->name?></td>
                            <td><?=$single->entry_project?></td>
                            <td><?=$single->field_type?></td>
                            <td><?=$single->tournament0->name?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif;?>

    <?php if(!empty($doubles)):?>
        <div class="active-record">
            <label for="">参加双打比赛<?= count($doubles)?>次</label>
            <div class="record col-xs-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>地点</th>
                        <th>参赛项目</th>
                        <th>场地类型</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($doubles as $double):?>
                    <tr>
                        <td><?=$double->match_time?></td>
                        <td><?=$double->matchPlace->name?></td>
                        <td><?=$double->entry_project?></td>
                        <td><?=$double->field_type?></td>
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
