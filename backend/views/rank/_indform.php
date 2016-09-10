<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/14
 * Time: 14:48
 */
/**
 * @var $data
 */
//var_dump($data);
?>
<?php if(is_array($data)){?>
    <div class="container">
        <div class="col-lg-offset-5 col-xs-2">
            <h4><?=$this->title?></h4>
        </div>
        <div class="">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>组别</th>
                    <th>排名</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>积分</th>
                    <th>52周胜率%</th>
                    <th>52周胜场数</th>
                    <th>52周净胜局</th>
                    <th>52周总场数</th>
                    <th>下周扣除积分</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $index => $player):?>
                    <tr>
                        <td style="color:<?php if($player['group']=='金') echo 'darkgoldenrod'; else echo 'gray';?>"><?=$player['group']?></td>
                        <td><?= $index+1?></td>
                        <td><?=$player['name']?></td>
                        <td><?=$player['gender']?></td>
                        <td><?=$player['point']?></td>
                        <td><?=$player['win_rate']?></td>
                        <td><?=$player['win_matches']?></td>
                        <td><?=$player['margin_bureau']?></td>
                        <td><?=$player['total_matches']?></td>
<!--                        上一年当周积分-->
                        <td style="color: <?php if($player['deduct_mark']>0) echo "red";?>;"><?=$player['deduct_mark']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
<?php }else{
    echo $data;
}?>