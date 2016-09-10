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
const MEN_DOUBLE='男双';
const WOMEN_DOUBLE='女双';
const MIXED_DOUBLE='混双';
const NO_DATA='无比赛数据';
class RankController extends Controller{

    /**
     * @return string
     * 混合单打排名
     */
    public function actionSinglesRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //获取当前赛季每个球员的单打周积分
        $query=<<<EOT
SELECT `player`,`group`, `name`, `gender`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_single_point` INNER JOIN `aw_player_information` ON aw_player_information.id=aw_single_point.player 
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_single_point.is_invalidated=0 
ORDER BY aw_single_point.player, aw_single_point.year DESC
EOT;
        $players_arr=AwSinglePoint::findBySql($query)->asArray()->all();
        return $this->render('singles-rank',['data'=>MyFunction::IndividualRank($players_arr,MyFunction::EntryProject()[MIXED])]);
    }

    /**
     * @return string
     * 女单排名
     */
    public function actionWomenRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季个人周积分
        $query=<<<EOT
SELECT `player`,`group`, `name`, `gender`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_women_individual_point` INNER JOIN `aw_player_information` ON aw_player_information.id=aw_women_individual_point.player 
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_women_individual_point.is_invalidated=0 
ORDER BY aw_women_individual_point.player, aw_women_individual_point.year DESC
EOT;
        $players_arr=AwWomenIndividualPoint::findBySql($query)->asArray()->all();
        return $this->render('women-rank',['data'=>MyFunction::IndividualRank($players_arr,MyFunction::EntryProject()[WOMEN_SINGLE])]);
    }

    /**
     * @return string
     * 男单排名
     */
    public function actionMenRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季个人周积分
        $query=<<<EOT
SELECT `player`,`group`, `name`, `gender`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_men_individual_point` INNER JOIN `aw_player_information` ON aw_player_information.id=aw_men_individual_point.player 
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_men_individual_point.is_invalidated=0 
ORDER BY aw_men_individual_point.player, aw_men_individual_point.year DESC
EOT;
        $players_arr=AwMenIndividualPoint::findBySql($query)->asArray()->all();
        return $this->render('men-rank',['data'=>MyFunction::IndividualRank($players_arr, MyFunction::EntryProject()[MEN_SINGLE])]);
    }

    /**
     * @return string
     * 双打个人排名
     */
    public function actionDoublesIndividualRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季个人周积分
        $query=<<<EOT
SELECT `player`,`group`, `name`, `gender`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_double_individual_point` INNER JOIN `aw_player_information` ON aw_player_information.id=aw_double_individual_point.player 
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_double_individual_point.is_invalidated=0 
ORDER BY aw_double_individual_point.player, aw_double_individual_point.year DESC
EOT;
        $players_arr=AwDoubleIndividualPoint::findBySql($query)->asArray()->all();
        return $this->render('doubles-individual-rank',['data'=>MyFunction::IndividualRank($players_arr,MyFunction::EntryProject()[DOUBLES_INDIVIDUAL])]);
    }
    
    /**
     * @return string
     * 双打排名
     */
    public function actionDoublesRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季组合周积分
        $query=<<<EOT
SELECT `team`,`team_type`,`player1`, `player2`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_double_point` INNER JOIN `aw_team` ON aw_team.id=aw_double_point.team
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_double_point.is_invalidated=0 
ORDER BY aw_double_point.team, aw_double_point.year DESC
EOT;
        $teams_arr=AwDoublePoint::findBySql($query)->asArray()->all();
        return $this->render('doubles-rank',['data'=>MyFunction::TeamRank($teams_arr,MyFunction::EntryProject()[DOUBLES])]);
    }

    /**
     * @return string
     * 男双排名
     */
    public function actionMenDoubleRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季组合周积分
        $query=<<<EOT
SELECT `team`,`team_type`,`player1`, `player2`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_men_double_point` INNER JOIN `aw_team` ON aw_team.id=aw_men_double_point.team
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_men_double_point.is_invalidated=0 
ORDER BY aw_men_double_point.team, aw_men_double_point.year DESC
EOT;
        $teams_arr=AwDoublePoint::findBySql($query)->asArray()->all();
        return $this->render('men-double-rank',['data'=>MyFunction::TeamRank($teams_arr,MyFunction::EntryProject()[MEN_DOUBLE])]);
    }

    /**
     * @return string
     * 女双排名
     */
    public function actionWomenDoubleRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季组合周积分
        $query=<<< EOT
SELECT `team`,`team_type`,`player1`, `player2`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_women_double_point` INNER JOIN `aw_team` ON aw_team.id=aw_women_double_point.team
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_women_double_point.is_invalidated=0 
ORDER BY aw_women_double_point.team, aw_women_double_point.year DESC
EOT;
        $teams_arr=AwDoublePoint::findBySql($query)->asArray()->all();
        return $this->render('men-double-rank',['data'=>MyFunction::TeamRank($teams_arr,MyFunction::EntryProject()[WOMEN_DOUBLE])]);
    }

    /**
     * @return string
     * 混双排名
     */
    public function actionMixedDoubleRank(){
        $year=date('Y');
        $lastYear=$year-1;
        $week=date('W');
        //查询本赛季组合周积分
        $query=<<< EOT
SELECT `team`,`team_type`,`player1`, `player2`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year`,`week` 
FROM `aw_mixed_double_point` INNER JOIN `aw_team` ON aw_team.id=aw_mixed_double_point.team
WHERE ((year={$lastYear} AND week>{$week}) OR (year={$year} AND week<={$week})) AND aw_mixed_double_point.is_invalidated=0 
ORDER BY aw_mixed_double_point.team, aw_mixed_double_point.year DESC
EOT;
        $teams_arr=AwDoublePoint::findBySql($query)->asArray()->all();
        return $this->render('mixed-double-rank',['data'=>MyFunction::TeamRank($teams_arr,MyFunction::EntryProject()[MIXED_DOUBLE])]);
    }

    /**
     * @return string
     * the rank of singles in this season
     */
    public function actionSeasonSinglesRank(){
        $lastYear=date('Y')-1;
        $startDateTime="{$lastYear}-12-01 00:00:00";
        $query=<<< EOT
SELECT `player`,`group`, `name`, `gender`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year` 
FROM aw_single_point INNER JOIN aw_player_information ON aw_single_point.player=aw_player_information.id
WHERE aw_single_point.is_invalidated=0 AND (UNIX_TIMESTAMP(aw_single_point.create_at) BETWEEN UNIX_TIMESTAMP('{$startDateTime}') AND UNIX_TIMESTAMP(NOW())) 
ORDER BY `player`, `year`
EOT;
        $players_arr=AwSinglePoint::findBySql($query)->asArray()->all();
        return $this->render('season-singles-rank',['data'=>MyFunction::SeasonIndividualRank($players_arr,MyFunction::EntryProject()[MIXED])]);
    }

    /**
     * @return string
     * the rank of doubles-individuals in this season
     */
    public function actionSeasonDoublesIndividualRank(){
        $lastYear=date('Y')-1;
        $startDateTime="{$lastYear}-12-01 00:00:00";
        $query=<<< EOT
SELECT `player`,`group`, `name`, `gender`, `total_matches`,`win_matches`,`margin_bureau`,`point`,`year` 
FROM aw_double_individual_point INNER JOIN aw_player_information ON aw_double_individual_point.player=aw_player_information.id 
WHERE aw_double_individual_point.is_invalidated=0 AND (UNIX_TIMESTAMP(aw_double_individual_point.create_at) BETWEEN UNIX_TIMESTAMP('{$startDateTime}') AND UNIX_TIMESTAMP(NOW())) 
ORDER BY `player`, `year`
EOT;
        $players_arr=AwSinglePoint::findBySql($query)->asArray()->all();
        return $this->render('season-singles-rank',['data'=>MyFunction::SeasonIndividualRank($players_arr,MyFunction::EntryProject()[DOUBLES_INDIVIDUAL])]);
    }
}