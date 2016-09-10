<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/7/28
 * Time: 22:44
 */
use common\base\MyFunction;
/**
 * @var $data
 */

//$teamType=array_flip(MyFunction::EntryProject());
?>
<?php if(is_array($data)){?>
    <div class="container">
        <div class="col-lg-offset-5 col-xs-2">
            <h4><?= $this->title?></h4>
        </div>
        <div class="">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>排名</th>
                    <th>组合</th>
                    <th>组合类型</th>
                    <th>积分</th>
                    <th>52周胜率%</th>
                    <th>52周胜场数</th>
                    <th>52周净胜局</th>
                    <th>52周总场数</th>
                    <th>下周扣除积分</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $index => $team):?>
                    <tr>
                        <td><?= $index+1?></td>
                        <td><?= $team['player1_name'].'&'.$team['player2_name']?></td>
                        <td><?= MyFunction::EntryProject_flip()[$team['team_type']]?></td>
                        <td><?= $team['point']?></td>
                        <td><?= $team['win_rate']?></td>
                        <td><?= $team['win_matches']?></td>
                        <td><?= $team['margin_bureau']?></td>
                        <td><?= $team['total_matches']?></td>
                        <td><?= $team['deduct_mark']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
<?php }else{
    echo $data;
}?>