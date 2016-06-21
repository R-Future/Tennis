<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/28
 * Time: 0:13
 */
namespace backend\controllers;

use common\base\MyFunction;
use common\models\AwPlayerInformation;
use yii\web\Controller;
use common\models\AwSinglePoint;
use common\models\AwWomenIndividualPoint;
use common\models\AwMenIndividualPoint;
use common\models\AwDoublePoint;
use common\models\AwDoubleIndividualPoint;
use common\models\AwIndividualRank;
const MIXED='混单';
const DOUBLES='双打';
const WOMEN_SINGLE='女单';
const MEN_SINGLE='男单';
const DOUBLES_INDIVIDUAL="双打个人";
const NO_DATA='无比赛数据';
class RankController extends Controller{

    /**
     * @return string
     * 混合单打排名
     */
    public function actionSinglesRank(){
        $year=date('Y');
        $week=date('W');
        //获取当前赛季每个球员的单打周积分
        $players_arr=AwSinglePoint::find()->
        innerJoin('aw_player_information','aw_single_point.player=aw_player_information.id')->
        select(['player','group', 'name', 'gender', 'total_matches','win_matches','margin_bureau','point','aw_single_point.year','aw_single_point.week'])->
        where(['and',['or',['and','year'=>$year-1,['>','week',$week]],['and','year'=>$year,['<=','week',$week]]],['aw_single_point.is_invalidated'=>false]])->
        orderBy('player')->asArray()->all();
        
        return $this->render('singles-rank',['data'=>MyFunction::rank($players_arr,MIXED)]);
    }

    /**
     * @return string
     * 女单排名
     */
    public function actionWomenRank(){
        $year=date('Y');
        $week=date('W');
        $players_arr=AwWomenIndividualPoint::find()->
        innerJoin('aw_player_information','aw_women_individual_point.player=aw_player_information.id')->
        select(['player', 'group','name','gender','total_matches','win_matches','margin_bureau','point','aw_women_individual_point.year','aw_women_individual_point.week'])->
        where(['and',['or',['and','year'=>$year-1,['>','week',$week]],['and','year'=>$year,['<=','week',$week]]],['aw_women_individual_point.is_invalidated'=>false]])->
        orderBy('player')->asArray()->all();
        return $this->render('women-rank',['data'=>MyFunction::rank($players_arr,WOMEN_SINGLE)]);
    }

    /**
     * @return string
     * 男单排名
     */
    public function actionMenRank(){
        $year=date('Y');
        $week=date('W');
        $players_arr=AwMenIndividualPoint::find()->
        innerJoin('aw_player_information','aw_men_individual_point.player=aw_player_information.id')->
        select(['player','group','name','gender','total_matches','win_matches','margin_bureau','point','aw_men_individual_point.year','aw_men_individual_point.week'])->
        where(['and',['or',['and','year'=>$year-1,['>','week',$week]],['and','year'=>$year,['<=','week',$week]]],['aw_men_individual_point.is_invalidated'=>false]])->
        orderBy('player')->asArray()->all();
        return $this->render('men-rank',['data'=>MyFunction::rank($players_arr, MEN_SINGLE)]);
    }

    /**
     * @return string
     * 双打个人排名
     */
    public function actionDoublesIndividualRank(){
        $year=date('Y');
        $week=date('W');
        $players_arr=AwDoubleIndividualPoint::find()->
        innerJoin('aw_player_information','aw_double_individual_point.player=aw_player_information.id')->
        select(['player', 'group','name','gender','total_matches','win_matches','margin_bureau','point','aw_double_individual_point.year','aw_double_individual_point.week'])->
        where(['and',['or',['and','year'=>$year-1,['>','week',$week]],['and','year'=>$year,['<=','week',$week]]],['aw_double_individual_point.is_invalidated'=>false]])->
        orderBy('player')->asArray()->all();
        return $this->render('doubles-individual-rank',['data'=>MyFunction::rank($players_arr,DOUBLES_INDIVIDUAL)]);
    }
    
    /**
     * @return string
     * 双打排名
     */
    public function actionDoublesRank(){
        $year=date('Y');
        $week=date('W');
        $teams_arr=AwDoublePoint::find()->
        innerJoin('aw_team','aw_double_point.team=aw_team.id')->
        select(['team','player1','player2','total_matches','win_matches','margin_bureau','point','aw_double_point.year','aw_double_point.week'])->
        where(['and',['or',['and','year'=>$year-1,['>','week',$week]],['and','year'=>$year,['<=','week',$week]]],['aw_double_point.is_invalidated'=>false]])->
        orderBy('team')->asArray()->all();
        //计算每对当前赛季的总积分
        $teams[]=array();
        $count=count($teams_arr);
        $j=0;
        for($i=0;$i<$count;$i++){
            if(empty($teams[$j])){
                $teams[$j]=$teams_arr[$i];
                $teams[$j]=array_merge($teams[$j],['active'=>0,'deduct_mark'=>0]);
            }else{
                if($teams[$j]['team']=$teams_arr[$i]['team']){
                    $teams[$j]['total_matches']+=$teams_arr[$i]['total_matches'];
                    $teams[$j]['win_matches']+=$teams_arr[$i]['win_matches'];
                    $teams[$j]['point']+=$teams_arr[$i]['point'];
                    $teams[$j]['margin_bureau']+=$teams_arr[$i]['margin_bureau'];
                }else{
                    $j++;
                    $teams[$j]=$teams_arr[$i];
                    $teams[$j]=array_merge($teams[$j],['active'=>0,'deduct_mark'=>0]);
                }
            }
            //计算当前赛季参赛次数
            if($teams_arr[$i]['year']==$year){
                $teams[$j]['active']++;
            }
            //计算下周要扣除的积分
            if($teams_arr[$i]['year']==$year-1&&$teams_arr[$i]['week']==$week+1){
                $teams[$j]['deduct_mark']=$teams_arr[$i]['point'];
            }
        }
        //计算每个球员当前赛季胜率
        if(!empty($teams[0])){
            foreach($teams as $index => $team){
                //查询数据库时，若只有一条数据则返回一维数组，若有多条数据则返回二维数组
                $player1=AwPlayerInformation::find()->select(['name','gender'])->where(['id'=>$team['player1']])->asArray()->one();
                $player2=AwPlayerInformation::find()->select(['name','gender'])->where(['id'=>$team['player2']])->asArray()->one();
                $win_rate=number_format($team['win_matches']/$team['total_matches']*100,2);

                if($player1['gender']=='男'&&$player2['gender']=='男'){
                    $team_type=['team_type'=>'男双'];
                }elseif($player1['gender']=='女'&&$player2['gender']=='女'){
                    $team_type=['team_type'=>'女双'];
                }else{
                    $team_type=['team_type'=>'混双'];
                }

                $teams[$index]=array_merge($team,['player1_name'=>$player1['name']],['player2_name'=>$player2['name']],$team_type,['win_rate'=>$win_rate]);
            }
            $teams=MyFunction::rankBubbleSort($teams);
            return $this->render('doubles-rank',['teams'=>$teams]);
        }else{
            return $this->render('doubles-rank',['no_data'=>NO_DATA]);
        }
    }
}