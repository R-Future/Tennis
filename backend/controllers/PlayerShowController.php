<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/14
 * Time: 21:44
 */
namespace backend\controllers;

use common\models\AwArena;
use yii\Web\Controller;
use common\models\AwPlayerInformation;
use common\models\AwIndividualRank;
use common\models\AwIndividualActive;
use common\models\AwSinglesMatch;
use common\models\AwTeam;
use common\models\AwDoublesMatch;
use common\models\AwActive;

class PlayerShowController extends Controller{
    /**
     * @return string
     */
    public function actionIndex(){
        $players=AwPlayerInformation::find()->select('name')->indexBy('id')->column();
        return $this->render('index',['players'=>$players]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionDetail($id){
        //球员信息
        $player=AwPlayerInformation::find()->where(['aw_player_information.id'=>$id])->asArray()->one();
        //排名
        $rank=AwIndividualRank::find()->where(['player'=>$id,'rank_type'=>'混单'])->asArray()->one();
        //活动
        $actives=AwIndividualActive::find()->innerJoin('aw_active','aw_active.id=aw_individual_active.active')->
                where(['player' => $id])->select(['aw_active.time','aw_active.place','aw_active.active'])->asArray()->all();
        foreach ($actives as $index => $active){
            $place=AwArena::findOne($active['place'])->name;
            $actives[$index]=array_merge($active,array('place'=>$place));
        }
        //单打比赛
        $singles_match=AwSinglesMatch::find()->where(['or','player'=>$id,'opponent'=>$id])->orderBy('match_time desc')->all();
//        $i=0;
//        $singles=array();
//        foreach ($singles_match as $match){
//
//        }
        //双打比赛
        $teams=AwTeam::find()->where(['or','player1'=>$id,'player2'=>$id])->select('id')->asArray()->all();
        $doubles_match=array();
        foreach($teams as $team){
            $tmp=AwDoublesMatch::find()->where(['or','team1'=>$team['id'],'team2'=>$team['id']])->orderBy('match_time desc')->all();
            $doubles_match=array_merge($doubles_match,$tmp);
        }
        return $this->renderPartial('detail',['player'=>$player,'rank'=>$rank,'actives'=>$actives,'singles'=>$singles_match,'doubles'=>$doubles_match]);
    }
}
