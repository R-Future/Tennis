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

const NO_DATA='无比赛数据';
class MyFunction {
    /**
     * @return string
     */
    static function getCurrentTime(){
        return date('Y-m-d').' '.(date('H')+6).':'.date('i:s');
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
     * Function: 为creat_at和update_at建立表单
     */
    static function timeForm($model){
        $form = ActiveForm::begin();
        return $form->field($model, 'create_at')->textInput(['value' => is_null($model->create_at)? self::getCurrentTime():$model->create_at]).
        $form->field($model, 'update_at')->textInput(['value' => self::getCurrentTime()]);
    }

    /**
     * @param $a
     * @param $b
     * 交换a,b的值
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
                    }elseif($arr[$j]['win_rate'==$arr[$i]['win_rate']]){
                        if($arr[$j]['margin_bureau']>$arr[$i]['margin_bureau']){
                            self::exchange($arr[$j],$arr[$i]);
                        }
                    }
                }
            }
        }
        return $arr;
    }

    /**
     * @param $players_arr
     * @return array|string
     * 计算积分排名
     */
    static function rank($players_arr,$rank_type){
        $year=date('Y');
        $week=date('W');
        //计算每个球员当前赛季的总积分
        $players[]=array();
        $count=count($players_arr);
        $j=0;
        for($i=0;$i<$count;$i++){
            if(empty($players[$j])){
                $players[$j]=$players_arr[$i];
                $players[$j]=array_merge($players[$j],['active'=>0,'deduct_mark'=>0]);
            }else{
                if($players[$j]['player']==$players_arr[$i]['player']){
                    $players[$j]['total_matches']+=$players_arr[$i]['total_matches'];
                    $players[$j]['win_matches']+=$players_arr[$i]['win_matches'];
                    $players[$j]['point']+=$players_arr[$i]['point'];
                    $players[$j]['margin_bureau']+=$players_arr[$i]['margin_bureau'];
                }else{
                    $j++;
                    $players[$j]=$players_arr[$i];
                    $players[$j]=array_merge($players[$j],['active'=>0,'deduct_mark'=>0]);
                }
            }
            //计算当前赛季积分
            if($players_arr[$i]['year']==$year){
                $players[$j]['active']++;
            }
            //计算下周要扣除的积分
            if($players_arr[$i]['year']==$year-1&&$players_arr[$i]['week']==$week){
                $players[$j]['deduct_mark']=$players[$i]['point'];
            }
        }
        //计算每个球员当前赛季胜率
        if(!empty($players[0])){
            foreach($players as $index => $player){
                $players[$index]=array_merge($player,['win_rate'=>number_format($player['win_matches']/$player['total_matches']*100,2)]);
            }
            $players=self::rankBubbleSort($players);//积分排序
            //记录个人名次信息
            foreach($players as $index => $player){
                $IndividualRank=AwIndividualRank::findOne(['player'=>$player['player'],'rank_type'=>$rank_type]);
                if(is_null($IndividualRank)){
                    $IndividualRank=new AwIndividualRank();
                    $IndividualRank->player=$player['player'];
                    $IndividualRank->rank_type=$rank_type;
                    $IndividualRank->total_points=$player['point'];
                    $IndividualRank->current_rank=$index+1;
                    $IndividualRank->highest_rank=$index+1;
                    $IndividualRank->week=$week;
                    $IndividualRank->create_at=self::getCurrentTime();
                    $IndividualRank->update_at=self::getCurrentTime();
                    $IndividualRank->save(false);//保存数据/
                }
                elseif($IndividualRank->total_points!=$player['point']){//总积分和排名实时更新
                    $IndividualRank->total_points=$player['point'];
                    $IndividualRank->current_rank=$index+1;
                    if($IndividualRank->week!=$week){//连续排名第一等信息每周更新一次
                        $IndividualRank->week=$week;
                        if($IndividualRank->current_rank==1){//上周排名第一
                            $IndividualRank->no1_weeks++;//排名第一总周数+1
                            $IndividualRank->consecutive_no1_weeks++;//连续排名第一周数+1
                        }else{//上周排名非第一
                            if($IndividualRank->consecutive_no1_weeks>$IndividualRank->longest_no1_weeks){//更新连续第一最长周数
                                $IndividualRank->longest_no1_weeks=$IndividualRank->consecutive_no1_weeks;
                            }
                            $IndividualRank->consecutive_no1_weeks=0;//连续第一终止
                        }
                    }
                    if($IndividualRank->highest_rank>($index+1)){//更新最高排名
                        $IndividualRank->highest_rank=$index+1;
                    }
                    $IndividualRank->update_at=self::getCurrentTime();
                    $IndividualRank->save(false);
                }
            }
            return $players;
        }else{
            return NO_DATA;
        }
    }

    /**
     * @param $playerModel
     * @param $newModel
     * @param $player_id
     * @param $point
     * @return mixed
     * 退赛扣分
     */
    static function penalty($playerModel,$newModel,$player_id,$point){
        $year=date('Y');
        $week=date('W');
        if(!empty($playerModel)){
            $playerModel->point-=$point;
        }else{
            $playerModel=$newModel;
            $playerModel->player=$player_id;
            $playerModel->year=$year;
            $playerModel->week=$week;
            $playerModel->point-=$point;
            $playerModel->create_at=self::getCurrentTime();
        }
        $playerModel->update_at=self::getCurrentTime();
        return $playerModel;
    }
}
?>