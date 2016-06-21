<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_doubles_match".
 *
 * @property integer $id
 * @property integer $team1
 * @property integer $team2
 * @property string $match_time
 * @property integer $match_place
 * @property string $entry_project
 * @property string $field_type
 * @property integer $tournament
 * @property integer $round
 * @property integer $sets
 * @property string $scores
 * @property string $win_loss
 * @property integer $team1_point
 * @property integer $team2_point
 * @property boolean $team1_quit
 * @property boolean $team2_quit
 * @property boolean $is_invalidated
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwArena $matchPlace
 * @property AwTournament $tournament0
 * @property AwTeam $team10
 * @property AwTeam $team20
 * @property AwMatchScore $matchScores
 * @property AwPointType $matchRound
 */
class AwDoublesMatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_doubles_match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team1', 'team2', 'match_place', 'tournament', 'round', 'sets', 'team1_point', 'team2_point'], 'integer'],
            [['team1_quit','team2_quit','is_invalidated'],'boolean'],
            [['match_time', 'create_at', 'update_at'], 'safe'],
            [['entry_project', 'field_type', 'win_loss'], 'string'],
            [['scores', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team1' => 'Team1',
            'team2' => 'Team2',
            'match_time' => '比赛时间',
            'match_place' => '比赛地点',
            'entry_project' => '比赛项目',
            'field_type' => '场地类型',
            'tournament' => '赛事类型',
            'round' => '轮次',
            'sets' => '盘数',
            'scores' => '比分',
            'win_loss' => '胜负',
            'team1_point' => '胜者积分',
            'team2_point' => '败者积分',
            'team1_quit' => 'team1退赛',
            'team2_quit' => 'team2退赛',
            'is_invalidated' => '比赛无效',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '备注',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatchPlace()
    {
        return $this->hasOne(AwArena::className(), ['id' => 'match_place']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament0()
    {
        return $this->hasOne(AwTournament::className(), ['id' => 'tournament']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam10()
    {
        return $this->hasOne(AwTeam::className(), ['id' => 'team1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam20()
    {
        return $this->hasOne(AwTeam::className(), ['id' => 'team2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatchScores()
    {
        return $this->hasMany(AwMatchScore::className(),['match_id'=>'scores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatchRound()
    {
        return $this->hasOne(AwPointType::className(),['round'=>'round']);
    }
}
