<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/28
 * Time: 0:14
 */

/**
 * @var $teams array
 * @var $no_data string
 */
$this->title='双打排名';
//var_dump($teams);
$this->registerCssFile('@web/css/table-center.css');
?>

<?php if(isset($no_data)):?>
<?= $no_data?>
<?php endif;?>
<?php if(isset($teams)):?>
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
                    <th>本赛季胜率</th>
                    <th>本赛季胜场数</th>
                    <th>本赛季净胜局</th>
                    <th>本赛季参赛次数</th>
                    <th>下周扣除积分</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($teams as $index => $team):?>
                    <tr>
                        <td><?= $index+1?></td>
                        <td><?= $team['player1_name'].'&'.$team['player2_name']?></td>
                        <td><?= $team['team_type']?></td>
                        <td><?= $team['point']?></td>
                        <td><?= $team['win_rate']?></td>
                        <td><?= $team['win_matches']?></td>
                        <td><?= $team['margin_bureau']?></td>
                        <td><?= $team['active']?></td>
                        <td><?= $team['deduct_mark']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
