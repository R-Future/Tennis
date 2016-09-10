<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/21
 * Time: 10:41
 */
namespace backend\controllers;

use Yii;
use common\base\MyFunction;
use common\models\AwTeam;
use yii\base\Exception;
use yii\swiftmailer\Message;
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
use common\models\AwMenDoublePoint;
use common\models\AwWomenDoublePoint;
use common\models\AwMixedDoublePoint;
use common\models\AwPointType;
use yii\base\Model;
use yii\helpers\Html;
error_reporting(E_ALL & ~E_NOTICE);

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
class MatchRecordController extends Controller{

    /**
     * @return string
     */
    public function actionSingles(){
        //每场比赛记录统计两条
        $singles_matches=[new AwSinglesMatch()];//比赛记录
        $match_count=count(Yii::$app->request->post('AwSinglesMatch',[]));
        for($i=1;$i<$match_count;$i++){
            $singles_matches[]=new AwSinglesMatch();
        }

        $match_scores[]=[new AwMatchScore()];
        $sets_count=count(Yii::$app->request->post('AwMatchScore',[]));
        for($i=0;$i<$sets_count;$i++){
            for($j=0;$j<count($_POST["AwMatchScore"][$i]);$j++){
                $match_scores[$i][$j] = new AwMatchScore();
                $match_scores[$i][$j]->set = $_POST["AwMatchScore"][$i][$j]["set"];
                $match_scores[$i][$j]->player1_score = $_POST["AwMatchScore"][$i][$j]["player1_score"];
                $match_scores[$i][$j]->player2_score = $_POST["AwMatchScore"][$i][$j]["player2_score"];
                $match_scores[$i][$j]->tie_player1_score = $_POST["AwMatchScore"][$i][$j]["tie_player1_score"];
                $match_scores[$i][$j]->tie_player2_score = $_POST["AwMatchScore"][$i][$j]["tie_player2_score"];
            }
        }


        //数据存储成功后提示
        $alert=null;

//        if($singles_match->load(Yii::$app->request->post())&&$singles_match->validate()){
        if(Model::loadMultiple($singles_matches,Yii::$app->request->post())&&Model::validateMultiple($singles_matches)){

            $tournament=$singles_matches[0]->tournament;
            $field_type=$singles_matches[0]->field_type;
            $match_place=$singles_matches[0]->match_place;
            $match_time=$singles_matches[0]->match_time;
            $round=$singles_matches[0]->round;
            $sets=$singles_matches[0]->sets;

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($singles_matches as $index => $singles_match) {

                    $margin_bureau = 0;//净胜局
                    $player_set = 0;//盘
                    $opponent_set = 0;
                    //保证每场比赛比分的唯一性
                    $scores_id = 's' . (time() + $index);//第一条比赛记录的比分id
                    $scores_id0 = $scores_id . 'c';//第二条比赛记录的比分id

                    $singles_match->create_at = MyFunction::getCurrentTime();
                    $singles_match->update_at = MyFunction::getCurrentTime();
                    $singles_match->tournament = $tournament;
                    $singles_match->field_type = $field_type;
                    $singles_match->match_place = $match_place;
                    $singles_match->match_time = $match_time;
                    $singles_match->round = $round;
                    $singles_match->sets = $sets;

                    $year = date('Y', strtotime($singles_match->match_time));
                    $week = date('W', strtotime($singles_match->match_time));
                    $month = date('m', strtotime($singles_match->match_time));
                    if ($month == 1 && $week > 40) {//if the first week of this year is spliced with the latest week of last year, then it's regarded as the latest week of last year
                        $year--;
                    }

                    //根据球员性别，判断参赛项目
                    $player = AwPlayerInformation::findOne(['id' => $singles_match->player]);
                    $opponent = AwPlayerInformation::findOne(['id' => $singles_match->opponent]);
                    if ($player->gender == '男' && $opponent->gender == '男') $singles_match->entry_project = MyFunction::EntryProject()[MEN_SINGLE];
                    elseif ($player->gender == '女' && $opponent->gender == '女') $singles_match->entry_project = MyFunction::EntryProject()[WOMEN_SINGLE];
                    else $singles_match->entry_project = MyFunction::EntryProject()[MIXED];

                    if (Model::loadMultiple($match_scores[$index], Yii::$app->request->post()) && Model::validateMultiple($match_scores[$index])) {

                        //根据tournament和round查询积分规则获取比赛双方积分
                        $pointType = AwPointType::find()->select(['winner_point', 'loser_point', 'penalty'])->
                        where(['tournament' => $singles_match->tournament, 'round' => $singles_match->round])->one();

                        //统计比赛输赢
                        foreach ($match_scores[$index] as $match_score) {
                            if ($match_score->player1_score > $match_score->player2_score) {
                                $player_set++;
                            } elseif ($match_score->player1_score < $match_score->player2_score) {
                                $opponent_set++;
                            } else {
                                if ($match_score->tie_player1_score > $match_score->tie_player2_score) {
                                    $player_set++;
                                } elseif ($match_score->tie_player1_score < $match_score->tie_player2_score) {
                                    $opponent_set++;
                                } else {//平局--特殊情况，一般不会出现
                                    $player_set++;
                                    $opponent_set++;
                                }
                            }
                            //比赛双方净胜局
                            $margin_bureau += ($match_score->player1_score - $match_score->player2_score);
                            $match_score->match_id = $scores_id;

                            //记录第二条比赛记录的比分
                            $match_score0 = new AwMatchScore();
                            $match_score0->match_id = $scores_id0;
                            $match_score0->set = $match_score->set;
                            $match_score0->player1_score = $match_score->player2_score;
                            $match_score0->player2_score = $match_score->player1_score;
                            $match_score0->tie_player1_score = $match_score->tie_player2_score;
                            $match_score0->tie_player2_score = $match_score->tie_player1_score;

                            if (!($match_score->save(false) && $match_score0->save(false))) {//false-以免数据重复验证两次
                                throw new Exception("比分未保存成功");
                            }
                        }//endforeach

                        //记录积分
                        if ($player_set > $opponent_set) {
                            $singles_match->win_loss = 1;
                            $singles_match->player_point = $singles_match->player_quit ? ($pointType['winner_point'] + $pointType['penalty']) : $pointType['winner_point'];
                            if (!$singles_match->opponent_challenger) {
                                $singles_match->opponent_point = $singles_match->opponent_quit ? ($pointType['loser_point'] + $pointType['penalty']) : $pointType['loser_point'];
                            } else {
                                $singles_match->opponent_point = $singles_match->opponent_quit ? $pointType['penalty'] : 0;//if the loser is a challenger, his point will be 0
                            }
                        } elseif ($player_set < $opponent_set) {
                            $singles_match->win_loss = -1;
                            if (!$singles_match->player_challenger) {
                                $singles_match->player_point = $singles_match->player_quit ? ($pointType['loser_point'] + $pointType['penalty']) : $pointType['loser_point'];
                            } else {
                                $singles_match->player_point = $singles_match->player_quit ? $pointType['penalty'] : 0;//if the loser is a challenger, his point will be 0
                            }
                            $singles_match->opponent_point = $singles_match->opponent_quit ? ($pointType['winner_point'] + $pointType['penalty']) : $pointType['winner_point'];

                        } else {//比赛双方同时退赛（特殊情况，极少出现）
                            $singles_match->win_loss = 0;
                            $singles_match->player_point = $singles_match->player_quit && $singles_match->opponent_quit ? $pointType['penalty'] : round(($pointType['winner_point'] + $pointType['loser_point']) / 2);
                            $singles_match->opponent_point = $singles_match->player_point;
                        }

                        //统计单打title
                        switch ($singles_match->tournament) {
                            case 1:
                            case 2:
                                if ($singles_match->round == 2) {
                                    if ($singles_match->win_loss == 1) {//player1获得冠军
                                        $playerModel = AwPlayerInformation::findOne(['id' => $singles_match->player]);
                                        $playerModel->singles_titles++;
                                        if (!$playerModel->save(false)) {
                                            throw new Exception();
                                        }
                                    } elseif ($singles_match->win_loss == -1) {//player2获得冠军
                                        $playerModel = AwPlayerInformation::findOne(['id' => $singles_match->opponent]);
                                        $playerModel->singles_titles++;
                                        if (!$playerModel->save(false)) {
                                            throw new Exception();
                                        }
                                    }
                                };
                                break;
                        }

                        //记录个人周积分
                        $players = array($singles_match->player, $singles_match->opponent);
                        $points = array($singles_match->player_point, $singles_match->opponent_point);
                        if ($singles_match->win_loss == 1) {
                            $win_loss = array(1, 0);
                        } elseif ($singles_match->win_loss == -1) {
                            $win_loss = array(0, 1);
                        } else {
                            $win_loss = array(0, 0);
                        }
                        $margin_bureaus = array($margin_bureau, -$margin_bureau);

                        //录入混合个人积分-AwSinglePoint
                        for ($i = 0; $i < 2; $i++) {
                            $single_point = AwSinglePoint::findOne(['player' => $players[$i], 'year' => $year, 'week' => $week]);
                            if (is_null($single_point)) {//如果数据库没存数据，则创建
                                $single_point = new AwSinglePoint();
                                $single_point->player = $players[$i];
                                $single_point->year = $year;
                                $single_point->week = $week;
                                $single_point->point = $points[$i];
                                $single_point->create_at = $singles_match->match_time;

                            } else {
                                if ($singles_match->tournament == 2) {//如果是年终总决赛，个人周积分不做累加
                                    $single_point->point = $points[$i];
                                } else {
                                    $single_point->point += $points[$i];
                                }
                            }
                            $single_point->update_at = MyFunction::getCurrentTime();
                            $single_point->total_matches += 1;
                            $single_point->win_matches += $win_loss[$i];
                            $single_point->margin_bureau += $margin_bureaus[$i];
                            //$single_point->save(false);
                            if (!$single_point->save(false)) {
                                throw new Exception();
                            }
                        }

                        switch ($singles_match->entry_project) {
                            case (MyFunction::EntryProject()[MEN_SINGLE]):
                                //录入男单当周个人积分-AwMenIndividualPoint
                                for ($i = 0; $i < 2; $i++) {
                                    $men_point = AwMenIndividualPoint::findOne(['player' => $players[$i], 'year' => $year, 'week' => $week]);
                                    if (is_null($men_point)) {
                                        $men_point = new AwMenIndividualPoint();
                                        $men_point->player = $players[$i];
                                        $men_point->year = $year;
                                        $men_point->week = $week;
                                        $men_point->point = $points[$i];
                                        $men_point->create_at = $singles_match->match_time;

                                    } else {
                                        if ($singles_match->tournament == 2) {//如果是年终总决赛，个人周积分不做累加
                                            $men_point->point = $points[$i];
                                        } else {
                                            $men_point->point += $points[$i];
                                        }
                                    }
                                    $men_point->update_at = MyFunction::getCurrentTime();
                                    $men_point->total_matches += 1;
                                    $men_point->win_matches += $win_loss[$i];
                                    $men_point->margin_bureau += $margin_bureaus[$i];
                                    if (!$men_point->save(false)) {
                                        throw new Exception();
                                    }
                                }
                                break;
                            case (MyFunction::EntryProject()[WOMEN_SINGLE]):
                                //录入女单当周个人积分-AwWomenIndividualPoint
                                for ($i = 0; $i < 2; $i++) {
                                    $women_point = AwWomenIndividualPoint::findOne(['player' => $players[$i], 'year' => $year, 'week' => $week]);
                                    if (is_null($women_point)) {
                                        $women_point = new AwWomenIndividualPoint();
                                        $women_point->player = $players[$i];
                                        $women_point->year = $year;
                                        $women_point->week = $week;
                                        $women_point->point = $points[$i];
                                        $women_point->create_at = $singles_match->match_time;

                                    } else {
                                        if ($singles_match->tournament == 2) {//如果是年终总决赛，个人周积分不做累加
                                            $women_point->point = $points[$i];
                                        } else {
                                            $women_point->point += $points[$i];
                                        }
                                    }
                                    $women_point->update_at = MyFunction::getCurrentTime();
                                    $women_point->total_matches += 1;
                                    $women_point->win_matches += $win_loss[$i];
                                    $women_point->margin_bureau += $margin_bureaus[$i];
                                    if (!$women_point->save(false)) {
                                        throw new Exception();
                                    }
                                }
                                break;
                        }
                    } else {
                        throw new Exception();
                    }//endif
                    $singles_match->scores = $scores_id;

                    //记录第二条比赛记录
                    $singles_match0 = new AwSinglesMatch();
                    $singles_match0->player = $singles_match->opponent;
                    $singles_match0->opponent = $singles_match->player;

                    $singles_match0->match_time = $singles_match->match_time;
                    $singles_match0->match_place = $singles_match->match_place;
                    $singles_match0->entry_project = $singles_match->entry_project;
                    $singles_match0->field_type = $singles_match->field_type;
                    $singles_match0->tournament = $singles_match->tournament;
                    $singles_match0->round = $singles_match->round;
                    $singles_match0->sets = $singles_match->sets;

                    $singles_match0->scores = $scores_id0;
                    $singles_match0->win_loss = -$singles_match->win_loss;
                    $singles_match0->player_point = $singles_match->opponent_point;
                    $singles_match0->opponent_point = $singles_match->player_point;
                    $singles_match0->player_challenger = $singles_match->opponent_challenger;
                    $singles_match0->opponent_challenger = $singles_match->player_challenger;
                    $singles_match0->player_quit = $singles_match->opponent_quit;
                    $singles_match0->opponent_quit = $singles_match->player_quit;

//                    $singles_match0->is_invalidated = $singles_match->is_invalidated;
                    $singles_match0->create_at = $singles_match->create_at;
                    $singles_match0->update_at = $singles_match->update_at;
                    $singles_match0->comment = $singles_match->comment;

                    if (!($singles_match->save(false) && $singles_match0->save(false))) {
                        throw new Exception();
                    } else {
                        $alert = '信息已保存 ' . MyFunction::getCurrentTime();
                    }
                }//endforeach
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                $alert = $e->getCustomMessage();
            }//endTry
        }//endif
        //refresh the page
        $singles_matches=[new AwSinglesMatch()];//比赛记录
        $match_scores = [[new AwMatchScore()]];//比分记录
        return $this->render('singles',['singles_matches'=>$singles_matches,'match_scores'=>$match_scores,'alert'=>$alert]);
    }

    /**
     * @return string
     */
    public function  actionDoubles(){

        $doubles_matches=[new AwDoublesMatch()];
        $match_count=count(Yii::$app->request->post('AwDoublesMatch',[]));
        for($i=1;$i<$match_count;$i++){
            $doubles_matches[]=new AwDoublesMatch();
        }

        $match_scores[]=[new AwMatchScore()];
        $sets_count=count(Yii::$app->request->post('AwMatchScore',[]));
        for($i=0;$i<$sets_count;$i++){
            for($j=0;$j<count($_POST["AwMatchScore"][$i]);$j++) {
                $match_scores[$i][$j] = new AwMatchScore();
                $match_scores[$i][$j]->set = $_POST["AwMatchScore"][$i][$j]["set"];
                $match_scores[$i][$j]->player1_score = $_POST["AwMatchScore"][$i][$j]["player1_score"];
                $match_scores[$i][$j]->player2_score = $_POST["AwMatchScore"][$i][$j]["player2_score"];
                $match_scores[$i][$j]->tie_player1_score = $_POST["AwMatchScore"][$i][$j]["tie_player1_score"];
                $match_scores[$i][$j]->tie_player2_score = $_POST["AwMatchScore"][$i][$j]["tie_player2_score"];
            }
        }

        //tip
        $alert=null;
        if(Model::loadMultiple($doubles_matches,Yii::$app->request->post())&&Model::validateMultiple($doubles_matches)){

            $tournament=$doubles_matches[0]->tournament;
            $field_type=$doubles_matches[0]->field_type;
            $match_place=$doubles_matches[0]->match_place;
            $match_time=$doubles_matches[0]->match_time;
            $round=$doubles_matches[0]->round;
            $sets=$doubles_matches[0]->sets;

            $transaction=Yii::$app->db->beginTransaction();
            try {
                foreach($doubles_matches as $index => $doubles_match) {
                    //盘
                    $team1_sets=0;
                    $team2_sets=0;
                    //净胜局
                    $margin_bureau=0;
                    //比分id
                    $scores_id='d'.(time()+$index);
                    $scores_id0=$scores_id.'c';

                    $doubles_match->create_at = MyFunction::getCurrentTime();
                    $doubles_match->update_at = MyFunction::getCurrentTime();
                    $doubles_match->tournament = $tournament;
                    $doubles_match->field_type = $field_type;
                    $doubles_match->match_place = $match_place;
                    $doubles_match->match_time = $match_time;
                    $doubles_match->round = $round;
                    $doubles_match->sets = $sets;

                    $year = date('Y', strtotime($doubles_match->match_time));
                    $week = date('W', strtotime($doubles_match->match_time));
                    $month = date('m', strtotime($doubles_match->match_time));
                    if ($month == 1 && $week > 40) {//if the first week of this year is spliced with the latest week of last year, then it's regarded as the latest week of last year
                        $year--;
                    }

                    //查询team表，判断组合类型
                    $team1_type = AwTeam::findOne(['id' => $doubles_match->team1])->team_type;
                    $team2_type = AwTeam::findOne(['id' => $doubles_match->team2])->team_type;
                    if ($team1_type == MyFunction::EntryProject()[MEN_DOUBLE] && $team2_type == MyFunction::EntryProject()[MEN_DOUBLE]) $doubles_match->entry_project = MyFunction::EntryProject()[MEN_DOUBLE];
                    elseif ($team1_type == MyFunction::EntryProject()[WOMEN_DOUBLE] && $team2_type == MyFunction::EntryProject()[WOMEN_DOUBLE]) $doubles_match->entry_project = MyFunction::EntryProject()[WOMEN_DOUBLE];
                    elseif ($team1_type == MyFunction::EntryProject()[MIXED_DOUBLE] && $team2_type == MyFunction::EntryProject()[MIXED_DOUBLE]) $doubles_match->entry_project = MyFunction::EntryProject()[MIXED_DOUBLE];
                    else $doubles_match->entry_project = MyFunction::EntryProject()[DOUBLES];

                    if (Model::loadMultiple($match_scores[$index], Yii::$app->request->post()) && Model::validateMultiple($match_scores[$index])) {

                        //根据赛事和轮次获取比赛积分
                        $pointType = AwPointType::find()->select(['winner_point', 'loser_point', 'penalty'])->
                        where(['tournament' => $doubles_match->tournament, 'round' => $doubles_match->round])->one();

                        foreach ($match_scores[$index] as $match_score) {
                            //通过每盘比分判断输赢
                            if ($match_score->player1_score > $match_score->player2_score) {
                                $team1_sets++;
                            } elseif ($match_score->player1_score < $match_score->player2_score) {
                                $team2_sets++;
                            } else {
                                if ($match_score->tie_player1_score > $match_score->tie_player2_score) {
                                    $team1_sets++;
                                } elseif ($match_score->tie_player1_score < $match_score->tie_player2_score) {
                                    $team2_sets++;
                                } else {
                                    $team1_sets++;
                                    $team2_sets++;
                                }
                            }
                            //比赛双方净胜局
                            $margin_bureau += ($match_score->player1_score - $match_score->player2_score);
                            //保存比分
                            $match_score->match_id = $scores_id;

                            //记录第二条双打比赛记录
                            $match_score0 = new AwMatchScore();
                            $match_score0->match_id = $scores_id0;
                            $match_score0->set = $match_score->set;
                            $match_score0->player1_score = $match_score->player2_score;
                            $match_score0->player2_score = $match_score->player1_score;
                            $match_score0->tie_player1_score = $match_score->tie_player2_score;
                            $match_score0->tie_player2_score = $match_score->tie_player1_score;

                            if(!($match_score->save(false)&&$match_score0->save(false))){
                                throw new Exception("比分未保存成功");
                            }
                        }
                        //计算比赛双方所获积分
                        if ($team1_sets > $team2_sets) {//team1胜
                            $doubles_match->win_loss = 1;
                            $doubles_match->team1_point = $doubles_match->team1_quit ? $pointType['winner_point'] + $pointType['penalty'] : $pointType['winner_point'];
                            $doubles_match->team2_point = $doubles_match->team2_quit ? $pointType['loser_point'] + $pointType['penalty'] : $pointType['loser_point'];
                        } elseif ($team1_sets < $team2_sets) {//team2胜
                            $doubles_match->win_loss = -1;
                            $doubles_match->team1_point = $doubles_match->team1_quit ? $pointType['loser_point'] + $pointType['penalty'] : $pointType['loser_point'];
                            $doubles_match->team2_point = $doubles_match->team2_quit ? $pointType['winner_point'] + $pointType['penalty'] : $pointType['winner_point'];
                        } else {//平手(1.比赛没打完按平局算；2.双方同时退赛)
                            $doubles_match->win_loss = 0;
                            $doubles_match->team1_point = $doubles_match->team2_point = $doubles_match->team1_quit && $doubles_match->team2_quit ? $pointType['penalty'] : round(($pointType['winner_point'] + $pointType['loser_point']) / 2);
                        }

                        //获取两队的球员
                        $team1 = AwTeam::findOne(['id' => $doubles_match->team1]);
                        $team2 = AwTeam::findOne(['id' => $doubles_match->team2]);
                        $team_players = array(array($team1->player1, $team1->player2), array($team2->player1, $team2->player2));
                        //统计双打title
                        switch ($doubles_match->tournament) {
                            case 1:
                            case 2:
                                if ($doubles_match->round == 2) {
                                    if ($doubles_match->win_loss == 1) {//player1获得冠军
                                        for ($i = 0; $i < 2; $i++) {
                                            $playerModel = AwPlayerInformation::findOne(['id' => $team_players[0][$i]]);
                                            $playerModel->singles_titles++;
                                            if(!$playerModel->save(false)){
                                                throw new Exception("保存双打title失败");
                                            }
                                        }
                                    } elseif ($doubles_match->win_loss == -1) {//player2获得冠军
                                        for ($i = 0; $i < 2; $i++) {
                                            $playerModel = AwPlayerInformation::findOne(['id' => $team_players[1][$i]]);
                                            $playerModel->singles_titles++;
                                            if(!$playerModel->save(false)){
                                                throw new Exception("保存双打title失败");
                                            }
                                        }
                                    }
                                };
                                break;
                        }

                        //记录比赛双方积分以及个人积分
                        $teams = array($doubles_match->team1, $doubles_match->team2);
                        $points = array($doubles_match->team1_point, $doubles_match->team2_point);
                        if ($doubles_match->win_loss == 1) $win_loss = array(1, 0);
                        elseif ($doubles_match->win_loss == -1) $win_loss = array(0, 1);
                        else $win_loss = array(0, 0);
                        $margin_bureaus = array($margin_bureau, -$margin_bureau);

                        //记录双打组合积分
                        for ($i = 0; $i < 2; $i++) {
                            $team_point = AwDoublePoint::findOne(['team' => $teams[$i], 'year' => $year, 'week' => $week]);
                            if (is_null($team_point)) {
                                $team_point = new AwDoublePoint();
                                $team_point->team = $teams[$i];
                                $team_point->year = $year;
                                $team_point->week = $week;
                                $team_point->point = $points[$i];
                                $team_point->create_at = $doubles_match->match_time;
                            } else {
                                if ($doubles_match->tournament == 2) {//如果是年终总决赛，周积分不做累加
                                    $team_point->point = $points[$i];
                                } else {
                                    $team_point->point += $points[$i];
                                }
                            }
                            $team_point->total_matches += 1;
                            $team_point->win_matches += $win_loss[$i];
                            $team_point->margin_bureau += $margin_bureaus[$i];
                            $team_point->update_at = MyFunction::getCurrentTime();
                            if(!$team_point->save(false)){
                                throw new Exception("保存组合积分失败");
                            }

                            //记录双打个人积分
                            for ($j = 0; $j < 2; $j++) {
                                $player_point = AwDoubleIndividualPoint::findOne(['player' => $team_players[$i][$j], 'year' => $year, 'week' => $week]);
                                if (is_null($player_point)) {
                                    $player_point = new AwDoubleIndividualPoint();
                                    $player_point->player = $team_players[$i][$j];
                                    $player_point->year = $year;
                                    $player_point->week = $week;
                                    $player_point->point = $points[$i];
                                    $player_point->create_at = $doubles_match->match_time;
                                } else {
                                    if ($doubles_match->tournament == 2) {//如果是年终总决赛，周积分不做累加
                                        $player_point->point = $points[$i];
                                    } else {
                                        $player_point->point += $points[$i];
                                    }
                                }
                                $player_point->total_matches += 1;
                                $player_point->win_matches += $win_loss[$i];
                                $player_point->margin_bureau += $margin_bureaus[$i];
                                $player_point->update_at = MyFunction::getCurrentTime();
                                $player_point->save(false);
                            }
                        }
                        //男双，女双，混双周积分统计
                        switch ($doubles_match->entry_project) {
                            case (MyFunction::EntryProject()[MEN_DOUBLE]):
                                for ($i = 0; $i < 2; $i++) {
                                    $team_point = AwMenDoublePoint::findOne(['team' => $teams[$i], 'year' => $year, 'week' => $week]);
                                    if (is_null($team_point)) {
                                        $team_point = new AwMenDoublePoint();
                                        $team_point->team = $teams[$i];
                                        $team_point->year = $year;
                                        $team_point->week = $week;
                                        $team_point->point = $points[$i];
                                        $team_point->create_at = $doubles_match->match_time;
                                    } else {
                                        if ($doubles_match->tournament == 2) {//如果是年终总决赛，周积分不做累加
                                            $team_point->point = $points[$i];
                                        } else {
                                            $team_point->point += $points[$i];
                                        }
                                    }
                                    $team_point->total_matches += 1;
                                    $team_point->win_matches += $win_loss[$i];
                                    $team_point->margin_bureau += $margin_bureaus[$i];
                                    $team_point->update_at = MyFunction::getCurrentTime();
                                    if(!$team_point->save(false)){
                                        throw new Exception("保存男双积分失败");
                                    }
                                }
                                break;
                            case (MyFunction::EntryProject()[WOMEN_DOUBLE]):
                                for ($i = 0; $i < 2; $i++) {
                                    $team_point = AwWomenDoublePoint::findOne(['team' => $teams[$i], 'year' => $year, 'week' => $week]);
                                    if (is_null($team_point)) {
                                        $team_point = new AwWomenDoublePoint();
                                        $team_point->team = $teams[$i];
                                        $team_point->year = $year;
                                        $team_point->week = $week;
                                        $team_point->point = $points[$i];
                                        $team_point->create_at = $doubles_match->match_time;
                                    } else {
                                        if ($doubles_match->tournament == 2) {//如果是年终总决赛，周积分不做累加
                                            $team_point->point = $points[$i];
                                        } else {
                                            $team_point->point += $points[$i];
                                        }
                                    }
                                    $team_point->total_matches += 1;
                                    $team_point->win_matches += $win_loss[$i];
                                    $team_point->margin_bureau += $margin_bureaus[$i];
                                    $team_point->update_at = MyFunction::getCurrentTime();
                                    if(!$team_point->save(false)){
                                        throw new Exception("保存女双积分失败");
                                    }
                                }
                                break;
                            case (MyFunction::EntryProject()[MIXED_DOUBLE]):
                                for ($i = 0; $i < 2; $i++) {
                                    $team_point = AwMixedDoublePoint::findOne(['team' => $teams[$i], 'year' => $year, 'week' => $week]);
                                    if (is_null($team_point)) {
                                        $team_point = new AwMixedDoublePoint();
                                        $team_point->team = $teams[$i];
                                        $team_point->year = $year;
                                        $team_point->week = $week;
                                        $team_point->point = $points[$i];
                                        $team_point->create_at = $doubles_match->match_time;
                                    } else {
                                        if ($doubles_match->tournament == 2) {//如果是年终总决赛，周积分不做累加
                                            $team_point->point = $points[$i];
                                        } else {
                                            $team_point->point += $points[$i];
                                        }
                                    }
                                    $team_point->total_matches += 1;
                                    $team_point->win_matches += $win_loss[$i];
                                    $team_point->margin_bureau += $margin_bureaus[$i];
                                    $team_point->update_at = MyFunction::getCurrentTime();
                                    if(!$team_point->save(false)){
                                        throw new Exception("保存混双积分失败");
                                    }
                                }
                                break;
                        }
                    }

                    $doubles_match->scores = $scores_id;

                    //记录第二条双打比赛记录
                    $doubles_match0 = new AwDoublesMatch();
                    $doubles_match0->team1 = $doubles_match->team2;
                    $doubles_match0->team2 = $doubles_match->team1;

                    $doubles_match0->match_time = $doubles_match->match_time;
                    $doubles_match0->match_place = $doubles_match->match_place;
                    $doubles_match0->entry_project = $doubles_match->entry_project;
                    $doubles_match0->field_type = $doubles_match->field_type;
                    $doubles_match0->tournament = $doubles_match->tournament;
                    $doubles_match0->round = $doubles_match->round;
                    $doubles_match0->sets = $doubles_match->sets;

                    $doubles_match0->scores = $scores_id0;
                    $doubles_match0->win_loss = -$doubles_match->win_loss;
                    $doubles_match0->team1_point = $doubles_match->team2_point;
                    $doubles_match0->team2_point = $doubles_match->team1_point;
                    $doubles_match0->team1_quit = $doubles_match->team2_quit;
                    $doubles_match0->team2_quit = $doubles_match->team1_quit;

                    //$doubles_match0->is_invalidated = $doubles_match->is_invalidated;
                    $doubles_match0->create_at = $doubles_match->create_at;
                    $doubles_match0->update_at = $doubles_match->update_at;
                    $doubles_match0->comment = $doubles_match->comment;

                    if (!($doubles_match->save(false) && $doubles_match0->save(false))) {
                        throw new Exception("保存双打比赛记录失败");
                    }else{
                        $alert = '信息已保存 ' . MyFunction::getCurrentTime();
                    }
                }
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollBack();
                $alert = $e->getMessage();
            }
        }//endif
        //refresh the page to be new after storing some match records
        $doubles_matches=[new AwDoublesMatch()];
        $match_scores=[[new AwMatchScore()]];
        return $this->render('doubles',['doubles_matches'=>$doubles_matches,'match_scores'=>$match_scores,'alert'=>$alert]);
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
            where(['player'=>$player1_id,'opponent'=>$player2_id,'aw_singles_match.is_invalidated'=>false])->
            orderBy('match_time DESC')->asArray()->all();
            //记录双方胜负数
            $player1_win=0;
            $player2_win=0;
            foreach ($records as $index => $record) {
                $match_score = AwMatchScore::find()->select(['player1_score', 'player2_score', 'tie_player1_score', 'tie_player2_score'])->
                where(['match_id' => $record['scores']])->orderBy('set')->asArray()->all();

                //比分
                $score_str='';

                foreach ($match_score as $value) {
                    if (is_null($value['tie_player1_score']) && is_null($value['tie_player2_score'])) {
                        $score_str .= $value['player1_score'] . ":" . $value['player2_score'];
                    } else {
                        $score_str .= $value['player1_score'] . "(" . $value['tie_player1_score'] . ")" . ":" .
                            $value['player2_score'] . "(" . $value['tie_player2_score'] . ")";
                    }
                }

                if ($record['win_loss'] == 1) $player1_win++;
                elseif ($record['win_loss'] == -1) $player2_win++;
                $versus = $player1_name . ' vs ' . $player2_name;

                $records[$index]=array_merge($record,['score_str'=>$score_str,'versus'=>$versus]);
            }
            return $this->renderPartial('head-to-head',['records'=>$records,'player1_win'=>$player1_win,'player2_win'=>$player2_win]);
        }else{
            return $this->render('player-search',['players' => $players]);
        }
    }


    /**
     * @param $tournament_id
     * 根据所选赛事，查询该赛事的所有比赛轮次
     */
    public function actionRound($tournament_id){
        $arr_round=(new AwPointType())->getRoundList($tournament_id);
        echo Html::tag('option',Html::encode('--请选择轮次--'),['value'=>'empty']);
        foreach ($arr_round as $round){
            echo Html::tag('option',Html::encode($round),array(['value'=>$round]));
        }
    }
}