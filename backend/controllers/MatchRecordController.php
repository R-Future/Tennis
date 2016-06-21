<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/21
 * Time: 10:41
 */
namespace backend\controllers;

use backend\models\searches\AwPlayerInformationtSearch;
use Yii;
use common\base\MyFunction;
use common\models\AwTeam;
use yii\web\Controller;
use common\models\AwPlayerInformation;
use common\models\AwSinglesMatch;
use common\models\AwDoublesMatch;
use common\models\AwMatchScore;
use common\models\AwSinglePoint;
use common\models\AwMenIndividualPoint;
use common\models\AwWomenIndividualPoint;
use common\models\AwDoublePoint;
use common\models\AwDoubleIndividualPoint;
use common\models\AwIndividualRank;
use common\models\AwPointType;
use backend\models\searches\AwSinglesMatchSearch;
use yii\base\Model;

const MIXED='混单';
const MEN_SINGLE='男单';
const WOMEN_SINGLE='女单';
const DOUBLES='双打';
const DOUBLES_INDIVIDUAL='双打个人';

class MatchRecordController extends Controller{
    public function actionSingles(){
        $singlesmatch=new AwSinglesMatch();

        $matchscores = [new AwMatchScore()];
        $scorecount=count(Yii::$app->request->post('AwMatchScore',[]));
        for($i=1;$i<$scorecount;$i++){
            $matchscores[] = new AwMatchScore();
        }

        $year=date('Y');//年份
        $week=date('W');//现年周数
        //净胜局
        $margin_bureau=0;
        //盘
        $player_set=0;
        $opponent_set=0;
        $scores_id='s'.time();
        //数据存储成功后提示
        $alert='';

        if($singlesmatch->load(Yii::$app->request->post())&&$singlesmatch->validate()){
            //保存前查询pointtype获取比赛双方积分
            $singlesmatch->create_at=MyFunction::getCurrentTime();
            $singlesmatch->update_at=MyFunction::getCurrentTime();

            if(Model::loadMultiple($matchscores,Yii::$app->request->post())&&Model::validateMultiple($matchscores)){

                //根据tournament和round查询积分规则
                $pointType=AwPointType::find()->select(['winner_point','loser_point','penalty'])->
                where(['tournament'=>$singlesmatch->tournament,'round'=>$singlesmatch->round])->one();

                //统计比赛输赢
                foreach ($matchscores as $matchscore) {
                    if($matchscore->player1_score>$matchscore->player2_score){
                        $player_set++;
                    }
                    elseif($matchscore->player1_score<$matchscore->player2_score){
                        $opponent_set++;
                    }
                    else{
                        if($matchscore->tie_player1_score>$matchscore->tie_player2_score){
                            $player_set++;
                        }
                        elseif($matchscore->tie_player1_score<$matchscore->tie_player2_score){
                            $opponent_set++;
                        }
                        else{//平局--特殊情况，一般不会出现
                            $player_set++;
                            $opponent_set++;
                        }
                    }
                    //比赛双方净胜局
                    $margin_bureau+=($matchscore->player1_score-$matchscore->player2_score);
                    //AwMatchScore->save
                    $matchscore->match_id=$scores_id;
                    $matchscore->save(false);//false-以免数据重复验证两次
                }

                //记录积分
                if($player_set>$opponent_set){
                    $singlesmatch->win_loss=1;
                    $singlesmatch->player_point = $singlesmatch->player_quit? ($pointType['winner_point'] + $pointType['penalty']):$pointType['winner_point'];
                    $singlesmatch->opponent_point = $singlesmatch->opponent_quit? ($pointType['loser_point']+$pointType['penalty']):$pointType['loser_point'];
                }
                elseif($player_set<$opponent_set){
                    $singlesmatch->win_loss=-1;
                    $singlesmatch->opponent_point = $singlesmatch->player_quit? ($pointType['winner_point'] + $pointType['penalty']):$pointType['winner_point'];
                    $singlesmatch->player_point = $singlesmatch->opponent_quit? ($pointType['loser_point']+$pointType['penalty']):$pointType['loser_point'];
                }
                else{
                    $singlesmatch->win_loss=0;
                    $singlesmatch->opponent_point=$singlesmatch->player_point = $singlesmatch->player_quit&&$singlesmatch->opponent_quit? $pointType['penalty']:round(($pointType['winner_point']+$pointType['loser_point'])/2);
                }

                //统计单打title
                switch ($singlesmatch->tournament){
                    case 1:
                    case 2:
                        if($singlesmatch->round==2){
                            if($singlesmatch->win_loss==1){//player1获得冠军
                                $playerModel=AwPlayerInformation::findOne(['id'=>$singlesmatch->player]);
                                $playerModel->singles_titles++;
                                $playerModel->save(false);
                            }elseif($singlesmatch->win_loss==-1){//player2获得冠军
                                $playerModel=AwPlayerInformation::findOne(['id'=>$singlesmatch->opponent]);
                                $playerModel->singles_titles++;
                                $playerModel->save(false);
                            }
                        };
                        break;
                }

                //记录个人周积分
                $players=array($singlesmatch->player,$singlesmatch->opponent);
                $points=array($singlesmatch->player_point,$singlesmatch->opponent_point);
                $win_loss=[];
                if($singlesmatch->win_loss==1){
                    $win_loss=array(1,0);
                }elseif($singlesmatch->win_loss==-1){
                    $win_loss=array(0,1);
                }
                $margin_bureaus=array($margin_bureau,-$margin_bureau);
                //录入混合个人积分-AwSinglePoint
                for($i=0;$i<2;$i++){
                    $single_point=AwSinglePoint::findOne(['player'=>$players[$i],'year'=>$year,'week'=>$week]);
                    if(is_null($single_point)){//如果数据库没存数据，则创建
                        $single_point=new AwSinglePoint();
                        $single_point->player=$players[$i];
                        $single_point->year=$year;
                        $single_point->week=$week;
                        $single_point->point=$points[$i];
                        $single_point->create_at=MyFunction::getCurrentTime();

                    }else{
                        $single_point->point+=$points[$i];
                    }
                    $single_point->update_at=MyFunction::getCurrentTime();
                    $single_point->total_matches+=1;
                    $single_point->win_matches+=$win_loss[$i];
                    $single_point->margin_bureau+=$margin_bureaus[$i];
                    $single_point->save(false);
                }

                switch($singlesmatch->entry_project){
                    case MEN_SINGLE:
                        //录入男单当周个人积分-AwMenIndividualPoint
                        for($i=0;$i<2;$i++){
                            $men_point=AwMenIndividualPoint::findOne(['player'=>$players[$i],'year'=>$year,'week'=>$week]);
                            if(is_null($men_point)){
                                $men_point=new AwMenIndividualPoint();
                                $men_point->player=$players[$i];
                                $men_point->year=$year;
                                $men_point->week=$week;
                                $men_point->point=$points[$i];
                                $men_point->create_at=MyFunction::getCurrentTime();

                            }else{
                                $men_point->point+=$points[$i];
                            }
                            $men_point->update_at=MyFunction::getCurrentTime();
                            $men_point->total_matches+=1;
                            $men_point->win_matches+=$win_loss[$i];
                            $men_point->margin_bureau+=$margin_bureaus[$i];
                            $men_point->save(false);
                        }
                        break;
                    case WOMEN_SINGLE:
                        //录入女单当周个人积分-AwWomenIndividualPoint
                        for($i=0;$i<2;$i++) {
                            $women_point = AwWomenIndividualPoint::findOne(['player' => $players[$i], 'year' => $year, 'week' => $week]);
                            if (is_null($women_point)) {
                                $women_point = new AwMenIndividualPoint();
                                $women_point->player = $players[$i];
                                $women_point->year = $year;
                                $women_point->week = $week;
                                $women_point->point = $points[$i];
                                $women_point->create_at = MyFunction::getCurrentTime();

                            } else {
                                $women_point->point += $points[$i];
                            }
                            $women_point->update_at = MyFunction::getCurrentTime();
                            $women_point->total_matches += 1;
                            $women_point->win_matches += $win_loss[$i];
                            $women_point->margin_bureau += $margin_bureaus[$i];
                            $women_point->save(false);
                        }
                }
            }
            $singlesmatch->scores=$scores_id;
            if ($singlesmatch->save(false)) {
                $alert='信息已保存 '.MyFunction::getCurrentTime();
                return $this->render('singles',['singlesmatch'=>$singlesmatch,'matchscores'=>$matchscores, 'alert'=>$alert]);
            }
        }else{
            return $this->render('singles',['singlesmatch'=>$singlesmatch,'matchscores'=>$matchscores,'alert'=>$alert]);
        }
    }

    public function  actionDoubles(){
        $doubles_match=new AwDoublesMatch();

        $sets_count=count(Yii::$app->request->post('AwMatchScore',[]));
        $match_scores=[new AwMatchScore()];
        for($i=1;$i<$sets_count;$i++){
            $match_scores[]=new AwMatchScore();
        }

        $year=date('Y');//当前年份
        $week=date('W');//现年第几周
        //盘
        $player1_sets=0;
        $player2_sets=0;
        //净胜局
        $margin_bureau=0;
        //比分id
        $scores_id='d'.time();
        //提醒
        $alert=null;

        if($doubles_match->load(Yii::$app->request->post())&&$doubles_match->validate()){

            $doubles_match->create_at=MyFunction::getCurrentTime();
            $doubles_match->update_at=MyFunction::getCurrentTime();

            if(Model::loadMultiple($match_scores,Yii::$app->request->post())&&Model::validateMultiple($match_scores)){

                //根据赛事和轮次获取比赛积分
                $pointType=AwPointType::find()->select(['winner_point','loser_point','penalty'])->
                    where(['tournament'=>$doubles_match->tournament,'round'=>$doubles_match->round])->one();

                foreach($match_scores as $match_score){
                    //通过每盘比分判断输赢
                    if($match_score->player1_score > $match_score->player2_score){
                        $player1_sets++;
                    }elseif($match_score->player1_score < $match_score->player2_score){
                        $player2_sets++;
                    }else{
                        if($match_score->tie_player1_score > $match_score->tie_player2_score){
                            $player1_sets++;
                        }elseif($match_score->tie_player1_score < $match_score->tie_player2_score){
                            $player2_sets++;
                        }
                        else{
                            $player1_sets++;
                            $player2_sets++;
                        }
                    }
                    //比赛双方净胜局
                    $margin_bureau+=($match_score->player1_score - $match_score->player2_score);
                    //保存比分
                    $match_score->match_id=$scores_id;
                    $match_score->save(false);
                }
                //计算比赛双方所获积分
                if($player1_sets > $player2_sets){//team1胜
                    $doubles_match->win_loss=1;
                    $doubles_match->team1_point=$doubles_match->team1_quit? $pointType['winner_point']+$pointType['penalty']:$pointType['winner_point'];
                    $doubles_match->team2_point=$doubles_match->team2_quit? $pointType['loser_point']+$pointType['penalty']:$pointType['loser_point'];
                }elseif($player1_sets < $player2_sets){//team2胜
                    $doubles_match->win_loss=-1;
                    $doubles_match->team1_point=$doubles_match->team1_quit? $pointType['loser_point']+$pointType['penalty']:$pointType['loser_point'];
                    $doubles_match->team2_point=$doubles_match->team2_quit? $pointType['winner_point']+$pointType['penalty']:$pointType['winner_point'];
                }else{//平手(1.比赛没打完按平局算；2.双方同时退赛)
                    $doubles_match->win_loss=0;
                    $doubles_match->team1_point = $doubles_match->team2_point = $doubles_match->team1_quit&&$doubles_match->team2_quit? $pointType['penalty']:round(($pointType['winner_point']+$pointType['loser_point'])/2);
                }

                //获取两队的球员
                $team1=AwTeam::findOne(['id'=>$doubles_match->team1]);
                $team2=AwTeam::findOne(['id'=>$doubles_match->team2]);
                $team_players=array(array($team1->player1,$team1->player2),array($team2->player1,$team2->player2));
                //统计双打title
                switch ($doubles_match->tournament){
                    case 1:
                    case 2:
                        if($doubles_match->round==2){
                            if($doubles_match->win_loss==1){//player1获得冠军
                                for($i=0;$i<2;$i++){
                                    $playerModel=AwPlayerInformation::findOne(['id'=>$team_players[0][$i]]);
                                    $playerModel->singles_titles++;
                                    $playerModel->save(false);
                                }
                            }elseif($doubles_match->win_loss==-1){//player2获得冠军
                                for($i=0;$i<2;$i++){
                                    $playerModel=AwPlayerInformation::findOne(['id'=>$team_players[1][$i]]);
                                    $playerModel->singles_titles++;
                                    $playerModel->save(false);
                                }
                            }
                        };
                        break;
                }

                //记录比赛双方积分以及个人积分
                $teams=array($doubles_match->team1,$doubles_match->team2);
                $points=array($doubles_match->team1_point,$doubles_match->team2_point);
                $win_loss=[];
                if($doubles_match->win_loss==1) $win_loss=array(1,0);
                elseif($doubles_match->win_loss==-1) $win_loss=array(0,1);
                $margin_bureaus=array($margin_bureau,-$margin_bureau);
                //记录双打组合积分
                for($i=0;$i<2;$i++){
                    $team_point=AwDoublePoint::findOne(['team'=>$teams[$i],'year'=>$year,'week'=>$week]);
                    if(is_null($team_point)){
                        $team_point=new AwDoublePoint();
                        $team_point->team=$teams[$i];
                        $team_point->year=$year;
                        $team_point->week=$week;
                        $team_point->point=$points[$i];
                        $team_point->create_at=MyFunction::getCurrentTime();
                    }else{
                        $team_point->point+=$points[$i];
                    }
                    $team_point->total_matches+=1;
                    $team_point->win_matches+=$win_loss[$i];
                    $team_point->margin_bureau+=$margin_bureaus[$i];
                    $team_point->update_at=MyFunction::getCurrentTime();
                    $team_point->save(false);
                    //记录双打个人积分
//                    $player_id=AwTeam::findOne(['id'=>$teams[$i]]);
//                    $team_players=array($player_id->player1,$player_id->player2);
                    for($j=0;$j<2;$j++){
                        $player_point=AwDoubleIndividualPoint::findOne(['player'=>$team_players[$i][$j],'year'=>$year,'week'=>$week]);
                        if(is_null($player_point)){
                            $player_point=new AwDoubleIndividualPoint();
                            $player_point->player=$team_players[$i][$j];
                            $player_point->year=$year;
                            $player_point->week=$week;
                            $player_point->point=$points[$i];
                            $player_point->create_at=MyFunction::getCurrentTime();
                        }else{
                            $player_point->point+=$points[$i];
                        }
                        $player_point->total_matches+=1;
                        $player_point->win_matches+=$win_loss[$i];
                        $player_point->margin_bureau+=$margin_bureaus[$i];
                        $player_point->update_at=MyFunction::getCurrentTime();
                        $player_point->save(false);
                    }
                }
                //以后扩展男双，女双...
            }

            $doubles_match->scores=$scores_id;
            if($doubles_match->save(false)){
                $alert='信息已保存 '.MyFunction::getCurrentTime();
                return $this->render('doubles',['doubles_match'=>$doubles_match,'match_scores'=>$match_scores,'alert'=>$alert]);
            }
        }else{
            return $this->render('doubles',['doubles_match'=>$doubles_match,'match_scores'=>$match_scores,'alert'=>$alert]);
        }
    }

    /**
     * @return string
     */
    public function actionPlayerSearch(){

        $players=AwPlayerInformation::find()->select(['id','name'])->asArray()->all();

        if(Yii::$app->request->isAjax){
            $data=Yii::$app->request->post();//获取post提交的值
            $player1_id=explode(":", $data['player1_id']);
            $player2_id=explode(":", $data['player2_id']);
            $player1_name=explode(":", $data['player1_name']);
            $player2_name=explode(":", $data['player2_name']);
            $player1_id=$player1_id[0];
            $player2_id=$player2_id[0];
            $player1_name=$player1_name[0];
            $player2_name=$player2_name[0];
            //查询数据库
            $records=AwSinglesMatch::find()->innerJoin('aw_arena','aw_singles_match.match_place=aw_arena.id')->
            innerJoin('aw_tournament','aw_singles_match.tournament=aw_tournament.id')->
            select(['player','opponent','match_time','aw_arena.name','aw_singles_match.field_type','aw_tournament.name','aw_singles_match.round','scores','win_loss'])->
            where(['or',['player'=>$player1_id,'opponent'=>$player2_id,'aw_singles_match.is_invalidated'=>false],['player'=>$player2_id,'opponent'=>$player1_id,'aw_singles_match.is_invalidated'=>false]])->
            orderBy('match_time DESC')->asArray()->all();
            //记录双方胜负数
            $player1_win=0;
            $player2_win=0;
            foreach ($records as $index => $record) {
                $match_score = AwMatchScore::find()->select(['player1_score', 'player2_score', 'tie_player1_score', 'tie_player2_score'])->
                where(['match_id' => $record['scores']])->orderBy('set')->asArray()->all();

                //比分
                $score_str='';
//                if($record['player']==$player1_id) {
                foreach ($match_score as $value) {
                    if (is_null($value['tie_player1_score']) && is_null($value['tie_player2_score'])) {
                        $score_str .= $value['player1_score'] . ":" . $value['player2_score'];
                    } else {
                        $score_str .= $value['player1_score'] . "(" . $value['tie_player1_score'] . ")" . ":" .
                            $value['player2_score'] . "(" . $value['tie_player2_score'] . ")";
                    }
                }

                if ($record['player'] == $player1_id) {
                    if ($record['win_loss'] == 1) $player1_win++;
                    elseif ($record['win_loss'] == -1) $player2_win++;
                    $versus = $player1_name . ' vs ' . $player2_name;
                } else {
                    if ($record['win_loss'] == 1) {
                        $player2_win++;
                    } elseif ($record['win_loss'] == -1) {
                        $player1_win++;
                    }
                    $versus = $player2_name . ' vs ' . $player1_name;
                }

//                }else{
//                    foreach($match_score as $value){
//                        if(is_null($value['tie_player1_score'])&&is_null($value['tie_player2_score'])){
//                            $score_str.=$value['player2_score'].":".$value['player1_score'];
//                        }else{
//                            $score_str.=$value['player2_score']."(".$value['tie_player2_score'].")".":".
//                                $value['player1_score']."(".$value['tie_player1_score'].")";
//                        }
//                    }
//
//                }
                $records[$index]=array_merge($record,['score_str'=>$score_str,'versus'=>$versus]);
            }
            return $this->renderPartial('head-to-head',['records'=>$records,'player1_win'=>$player1_win,'player2_win'=>$player2_win]);
        }else{
            return $this->render('player-search',['players' => $players]);
        }
    }
}