<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/19
 * Time: 20:52
 */
namespace common\base;

use yii\widgets\ActiveForm;
use common\models\AwIndividualRank;
use common\models\AwPlayerInformation;
use common\models\AwDeductPoint;
use common\models\AwSeasonRank;
/**
 * 男单 -- 0
 * 女单 -- 1
 * 男双 -- 2
 * 女双 -- 3
 * 混双 -- 4
 * 双打个人 -- 5
 * 混单 -- 6
 * 双打 -- 7
 * */
const MIXED='混单';
const DOUBLES='双打';
const WOMEN_SINGLE='女单';
const MEN_SINGLE='男单';
const DOUBLES_INDIVIDUAL="双打个人";
const MEN_DOUBLE='男双';
const WOMEN_DOUBLE='女双';
const MIXED_DOUBLE='混双';
const NO_DATA='无比赛数据';
class MyFunction {

    /**
     * @return string
     */
    static function getCurrentTime(){
//        return date('Y-m-d').' '.(date('H')+6).':'.date('i:s');
        date_default_timezone_set("Asia/Shanghai");
        return date('Y-m-d').' '.date('H:i:s');
    }

    /**
     * @return bool|string
     */
    static function getCurrentDate(){
        return date('Y-m-d');
    }

    /**
     * @param $model
     * @return string
     *
     * author: Future
     * time: 21:32 20/5/2016
     * Function: the form of create_at and update_at
     */
    static function timeForm($model){
        $form = ActiveForm::begin();
        return $form->field($model, 'create_at')->textInput(['value' => is_null($model->create_at)? self::getCurrentTime():$model->create_at]).
        $form->field($model, 'update_at')->textInput(['value' => self::getCurrentTime()]);
    }

    /**
     * @param $a
     * @param $b
     * exchange the value of a and b
     */
    static function exchange(&$a,&$b){
        $buff=$a;
        $a=$b;
        $b=$buff;
    }

    /**
     * @param $arr
     * @return mixed
     */
    static function rankBubbleSort($arr){
        $count=count($arr);
        for($i=0;$i<$count;$i++){
            for($j=$i+1;$j<$count;$j++){
                if($arr[$j]['point']>$arr[$i]['point']){
                    self::exchange($arr[$j],$arr[$i]);
                }elseif($arr[$j]['point']==$arr[$i]['point']){
                    if($arr[$j]['win_rate']>$arr[$i]['win_rate']){
                        self::exchange($arr[$j],$arr[$i]);
                    }elseif($arr[$j]['win_rate']==$arr[$i]['win_rate']){
                        if($arr[$j]['margin_bureau']>$arr[$i]['margin_bureau']){
                            self::exchange($arr[$j],$arr[$i]);
                        }else{}
                    }else{}
                }else{}
            }
        }
        return $arr;
    }

    /**
     * @param $players_arr
     * @param $rank_type
     * @param $s_member
     * @param $year
     * @param $week
     * update the rank including individual and team
     */
    static function UpdateRank($players_arr,$rank_type,$s_member,$year,$week)
    {
        //记录个人名次信息
        foreach ($players_arr as $index => $player) {
            $IndividualRank = AwIndividualRank::findOne(['player' => $player[$s_member], 'rank_type' => $rank_type, 'year' => $year]);
            if (is_null($IndividualRank)) {
                $IndividualRank = new AwIndividualRank();
                $IndividualRank->player = $player[$s_member];
                $IndividualRank->rank_type = $rank_type;
                $IndividualRank->total_points = $player['point'];
                $IndividualRank->rank_lift = 0;
                $IndividualRank->win_matches = $player['win_matches'];
                $IndividualRank->total_matches = $player['total_matches'];
                $IndividualRank->margin_bureau = $player['margin_bureau'];
                $IndividualRank->next_week_deduct_point = $player['deduct_mark'];
                $IndividualRank->current_rank = $index + 1;
                $IndividualRank->highest_rank = $index + 1;
                $IndividualRank->highest_rank_start_at = self::getCurrentDate();

                //处理两年交替第一次刷新排名时排名第一周数、连续第一周数、连续第一最长周数
                $LastYearRank = AwIndividualRank::findOne(['player' => $player[$s_member], 'rank_type' => $rank_type, 'year' => $year - 1]);
                if (!is_null($LastYearRank)) {
                    if ($LastYearRank->consecutive_no1_weeks > 0) {
                        $IndividualRank->no1_weeks = $LastYearRank->no1_weeks + $week;
                        if ($IndividualRank->current_rank == 1) {//如果本赛季刷新排名后其仍为第一，则保持连续第一
                            $IndividualRank->consecutive_no1_weeks = $LastYearRank->consecutive_no1_weeks + $week;
                        } else {//否则连续第一终止
                            $IndividualRank->consecutive_no1_weeks = 0;
                        }
                        if (($LastYearRank->consecutive_no1_weeks + $week) > $LastYearRank->longest_no1_weeks) {
                            $IndividualRank->longest_no1_weeks = $LastYearRank->consecutive_no1_weeks + $week;
                        } else {
                            $IndividualRank->longest_no1_weeks = $LastYearRank->longest_no1_weeks;
                        }
                    } else {
                        $IndividualRank->no1_weeks = $LastYearRank->no1_weeks;
                        $IndividualRank->consecutive_no1_weeks = 0;
                        $IndividualRank->longest_no1_weeks = $LastYearRank->longest_no1_weeks;
                    }
                } else {//新人
                    $IndividualRank->no1_weeks = 0;
                    $IndividualRank->consecutive_no1_weeks = 0;
                    $IndividualRank->longest_no1_weeks = 0;
                }

                $IndividualRank->year = $year;
                $IndividualRank->week = $week;
                $IndividualRank->create_at = self::getCurrentTime();
                $IndividualRank->update_at = self::getCurrentTime();
            } elseif ($IndividualRank->total_points != $player['point'] || $IndividualRank->current_rank != $index + 1) {//总积分和排名实时更新
                $IndividualRank->total_points = $player['point'];
                $IndividualRank->rank_lift = $IndividualRank->current_rank - $index - 1;
                $IndividualRank->current_rank = $index + 1;

                $IndividualRank->win_matches = $player['win_matches'];
                $IndividualRank->total_matches = $player['total_matches'];
                $IndividualRank->margin_bureau = $player['margin_bureau'];
                $IndividualRank->next_week_deduct_point = $player['deduct_mark'];

                if ($IndividualRank->current_rank == 1) {//上周排名第一
                    $weeks = $week - $IndividualRank->week;
                    $IndividualRank->no1_weeks += $weeks;//更新排名第一总周数
                    $IndividualRank->consecutive_no1_weeks += $weeks;//更新连续排名第一周数
                } else {//上周排名非第一
                    if ($IndividualRank->consecutive_no1_weeks > $IndividualRank->longest_no1_weeks) {//更新连续第一最长周数
                        $IndividualRank->longest_no1_weeks = $IndividualRank->consecutive_no1_weeks;
                    }else{}
                    $IndividualRank->consecutive_no1_weeks = 0;//连续第一终止
                }

                if ($IndividualRank->highest_rank > ($index + 1)) {//更新最高排名
                    $IndividualRank->highest_rank = $index + 1;
                    $IndividualRank->highest_rank_start_at = self::getCurrentDate();
                }else{}

                $IndividualRank->year = $year;
                $IndividualRank->week = $week;
                $IndividualRank->update_at = self::getCurrentTime();
            }else{}
            $IndividualRank->save(false);//保存数据/
        }
    }

    /**
     * @param $players_arr
     * @param $rank_type
     * @return array|string
     * 计算积分排名
     */
    static function IndividualRank($players_arr,$rank_type){
        $year=date('Y');
        $week=date('W');
        $month=date('m');
        if($month==1&&$week>40){
            $year--;
        }
        //计算每个球员当前赛季的总积分
        $players[]=array();
        $count=count($players_arr);
        $j=0;
        for($i=0;$i<$count;$i++){
            if(empty($players[$j])){
                $players[$j]=$players_arr[$i];
                $players[$j]=array_merge($players[$j],['deduct_mark'=>0]);
            }else{
                if($players[$j]['player']==$players_arr[$i]['player']){
                    $players[$j]['point']+=$players_arr[$i]['point'];//计算该球员当前赛季总积分
                    //if($players_arr[$i]['year']==$year) {//计算52周的总比赛场数，胜场数，净胜局
                    $players[$j]['total_matches'] += $players_arr[$i]['total_matches'];
                    $players[$j]['win_matches'] += $players_arr[$i]['win_matches'];
                    $players[$j]['margin_bureau'] += $players_arr[$i]['margin_bureau'];
                    //}else{}
                    //计算下周要扣除的积分
                    if($players_arr[$i]['year']==$year-1&&$players_arr[$i]['week']==$week+1){
                        $players[$j]['deduct_mark']=$players_arr[$i]['point'];
                    }else{}
                }else{
                    $j++;
                    $players[$j]=$players_arr[$i];
                    $players[$j]=array_merge($players[$j],['deduct_mark'=>0]);
                }
            }
            //计算当前赛季参赛次数
//            if($players_arr[$i]['year']==$year){
//                $players[$j]['active']++;
//            }
        }
        //计算每个球员当前赛季胜率
        if(!empty($players[0])){
            foreach($players as $index => $player){
                //扣除退赛扣分
                if($rank_type==self::EntryProject()[MIXED]) {
                    $deduct_point = AwDeductPoint::find()->select('point')->where(['player' => $player['player'], 'is_invalidated' => 0])->asArray()->all();
                }else {
                    $deduct_point = AwDeductPoint::find()->select('point')->where(['player' => $player['player'], 'entry_project' => $rank_type, 'is_invalidated' => 0])->asArray()->all();
                }
                $deduct_point=array_column($deduct_point,'point');//将二维数组转化成一维数组
                $player['point']+=array_sum($deduct_point);//对数组求和
                //胜率
                $players[$index]=array_merge($player,['win_rate'=>number_format($player['win_matches']/$player['total_matches']*100,2)]);
            }
            $players=self::rankBubbleSort($players);//积分排序
            self::UpdateRank($players,$rank_type,"player",$year,$week);
            return $players;
        }else{
            return NO_DATA;
        }
    }

    /**
     * @param $teams_arr
     * @param $rank_type
     * @return array|string
     */
    static function TeamRank($teams_arr,$rank_type){
        $year=date('Y');
        $week=date('W');
        $month=date('m');
        if($month==1&&$week>40){
            $year--;
        }
        //计算每个组合当前赛季的总积分
        $teams[]=array();
        $count=count($teams_arr);
        $j=0;
        for($i=0;$i<$count;$i++){
            if(empty($teams[$j])){
                $teams[$j]=$teams_arr[$i];
                $teams[$j]=array_merge($teams[$j],['deduct_mark'=>0]);
            }else{
                if($teams[$j]['team']==$teams_arr[$i]['team']){
                    $teams[$j]['point']+=$teams_arr[$i]['point'];//计算该球员当前赛季总积分
                    //if($teams_arr[$i]['year']==$year) {//计算52周的总比赛场数，胜场数，净胜局
                        $teams[$j]['total_matches'] += $teams_arr[$i]['total_matches'];
                        $teams[$j]['win_matches'] += $teams_arr[$i]['win_matches'];
                        $teams[$j]['margin_bureau'] += $teams_arr[$i]['margin_bureau'];
                    //}else{}
                    //计算下周要扣除的积分
                    if($teams_arr[$i]['year']==$year-1&&$teams_arr[$i]['week']==$week+1){
                        $teams[$j]['deduct_mark']=$teams_arr[$i]['point'];
                    }else{}
                }else{
                    $j++;
                    $teams[$j]=$teams_arr[$i];
                    $teams[$j]=array_merge($teams[$j],['deduct_mark'=>0]);
                }
            }
            //计算当前赛季参赛次数
//            if($teams_arr[$i]['year']==$year){
//                $teams[$j]['active']++;
//            }
        }
        //计算每个组合当前赛季胜率及组合类型
        if(!empty($teams[0])){
            foreach($teams as $index => $team){
                //查询数据库时，若只有一条数据则返回一维数组，若有多条数据则返回二维数组
                $player1=AwPlayerInformation::findOne(['id'=>$team['player1']])->name;
                $player2=AwPlayerInformation::findOne(['id'=>$team['player2']])->name;
                $win_rate=number_format($team['win_matches']/$team['total_matches']*100,2);

                $teams[$index]=array_merge($team,['player1_name'=>$player1],['player2_name'=>$player2],['win_rate'=>$win_rate]);
            }
            $teams=self::rankBubbleSort($teams);//对组合进行排名
            self::UpdateRank($teams,$rank_type,"team",$year,$week);
            return $teams;
        }else{
            return NO_DATA;
        }
    }


    static function UpdateSeasonRank($players_arr,$rank_type)
    {
        $year=date('Y');
        if(date('m')==12){//the current season is started from December in last year
            $year--;
        }else{}
        //记录个人名次信息
        foreach ($players_arr as $index => $player) {
            $IndividualSeasonRank = AwSeasonRank::findOne(['player' => $player['player'], 'rank_type' => $rank_type, 'year' => $year]);
            if (is_null($IndividualSeasonRank)) {
                $IndividualSeasonRank = new AwSeasonRank();
                $IndividualSeasonRank->player = $player['player'];
                $IndividualSeasonRank->rank_type = $rank_type;
                $IndividualSeasonRank->total_points = $player['point'];
                $IndividualSeasonRank->rank_lift = 0;
                $IndividualSeasonRank->win_matches = $player['win_matches'];
                $IndividualSeasonRank->total_matches = $player['total_matches'];
                $IndividualSeasonRank->margin_bureau = $player['margin_bureau'];
                $IndividualSeasonRank->current_rank = $index + 1;
                $IndividualSeasonRank->highest_rank = $index + 1;
                $IndividualSeasonRank->highest_rank_start_at = self::getCurrentDate();
                $IndividualSeasonRank->year = $year;
                $IndividualSeasonRank->create_at = self::getCurrentTime();
                $IndividualSeasonRank->update_at = self::getCurrentTime();
            } elseif ($IndividualSeasonRank->total_points != $player['point'] || $IndividualSeasonRank->current_rank != $index + 1) {//总积分和排名实时更新
                $IndividualSeasonRank->total_points = $player['point'];
                $IndividualSeasonRank->rank_lift = $IndividualSeasonRank->current_rank - $index - 1;
                $IndividualSeasonRank->current_rank = $index + 1;
                $IndividualSeasonRank->win_matches = $player['win_matches'];
                $IndividualSeasonRank->total_matches = $player['total_matches'];
                $IndividualSeasonRank->margin_bureau = $player['margin_bureau'];

                if ($IndividualSeasonRank->highest_rank > ($index + 1)) {//更新最高排名
                    $IndividualSeasonRank->highest_rank = $index + 1;
                    $IndividualSeasonRank->highest_rank_start_at = self::getCurrentDate();
                }
                $IndividualSeasonRank->year = $year;
                $IndividualSeasonRank->update_at = self::getCurrentTime();
            }else{}
            $IndividualSeasonRank->save(false);//保存数据/
        }
    }

    /**
     * @param $players_arr
     * @param $rank_type
     * @return array|string
     * the rank of individuals in this season including singles and doubles
     */
    static function SeasonIndividualRank($players_arr,$rank_type){
        //计算每个球员当前赛季的总积分
        $players[]=array();
        $count=count($players_arr);
        $j=0;
        for($i=0;$i<$count;$i++){
            if(empty($players[$j])){
                $players[$j]=$players_arr[$i];
            }else{
                if($players[$j]['player']==$players_arr[$i]['player']){
                    $players[$j]['point']+=$players_arr[$i]['point'];//计算该球员当前赛季总积分
                    $players[$j]['total_matches'] += $players_arr[$i]['total_matches'];
                    $players[$j]['win_matches'] += $players_arr[$i]['win_matches'];
                    $players[$j]['margin_bureau'] += $players_arr[$i]['margin_bureau'];
                }else{
                    $j++;
                    $players[$j]=$players_arr[$i];
                }
            }
        }
        //计算每个球员当前赛季胜率
        if(!empty($players[0])){
            $match_time=(date('Y')-1)."-12-01";//deduct the point of the current season
            foreach($players as $index => $player){
                if($rank_type==self::EntryProject()[MIXED]) {//deducting point of singles match if he/she retired some matches
                    //扣除退赛扣分
                    $deduct_point = AwDeductPoint::find()->select('point')->where(['player' => $player['player'], 'entry_project'=>[self::EntryProject()[MEN_SINGLE],self::EntryProject()[WOMEN_SINGLE],self::EntryProject()[MIXED]], 'is_invalidated' => 0])->andWhere(['>=', 'match_time', $match_time])->asArray()->all();
                }else{
                    $deduct_point=AwDeductPoint::find()->select('point')->where(['player'=>$player['player'], 'entry_project'=>$rank_type, 'is_invalidated'=>0])->andWhere(['>=', 'match_time', $match_time])->asArray()->all();
                }
                $deduct_point = array_column($deduct_point, 'point');//将二维数组转化成一维数组
                $player['point'] += array_sum($deduct_point);//对数组求和
                //胜率
                $players[$index]=array_merge($player,['win_rate'=>number_format($player['win_matches']/$player['total_matches']*100,2)]);
            }
            $players=self::rankBubbleSort($players);//积分排序
            self::UpdateSeasonRank($players,$rank_type);
            return $players;
        }else{
            return NO_DATA;
        }
    }

    /**
     * @return array
     * the index of entry projects
     */
    static function EntryProject(){
        return array('男单'=>0,'女单'=>1,'男双'=>2,'女双'=>3,'混双'=>4,'双打个人'=>5,'混单'=>6,'双打'=>7);
    }

    /**
     * @return array
     * reverse the array of entry projects
     */
    static function EntryProject_flip(){
        return array('男单','女单','男双','女双','混双','双打个人','混单','双打');
    }
}
?>