<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_singles_match".
 *
 * @property integer $id
 * @property integer $player
 * @property integer $opponent
 * @property string $match_time
 * @property integer $match_place
 * @property integer $entry_project
 * @property string $field_type
 * @property integer $tournament
 * @property integer $round
 * @property integer $sets
 * @property string $scores
 * @property integer $win_loss
 * @property integer $player_point
 * @property integer $opponent_point
 * @property integer $player_challenger
 * @property integer $opponent_challenger
 * @property boolean $player_quit
 * @property boolean $opponent_quit
 * @property boolean $is_invalidated
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwTournament $tournament0
 * @property AwPlayerInformation $player0
 * @property AwPlayerInformation $opponent0
 * @property AwArena $matchPlace
 * @property AwMatchScore $matchScores
 * @property AwPointType $matchRound
 */
class AwSinglesMatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_singles_match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player', 'opponent', 'match_place', 'tournament', 'round', 'player_point', 'opponent_point'], 'integer'],
            [['entry_project'], 'integer', 'max'=>7,'min'=>0],
            [['win_loss'], 'integer', 'max'=>1,'min'=>-1],
            [['sets'], 'integer', 'max'=>5, 'min'=>1],
            [['player_challenger','opponent_challenger','player_quit', 'opponent_quit', 'is_invalidated'],'boolean'],
            [['match_time', 'create_at', 'update_at'], 'safe'],
            [['match_time'], 'date', 'format'=>'php:Y-m-d'],
            [['field_type'], 'string'],
            [['scores', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'player' => '球员1',
            'opponent' => '球员2',
            'match_time' => '比赛时间',
            'match_place' => '比赛地点',
            'entry_project' => '参赛项目（1-男单/2-女单/7-混单）',
            'field_type' => '场地类型',
            'tournament' => '赛事类型',
            'round' => '轮次（0-小组赛/32-三十二强/16-十六强/8-八强/4-四强/2-决赛）',
            'sets' => '盘数',
            'scores' => '比分',
            'win_loss' => '胜负（1-胜/-1-负/0-平）',
            'player_point' => '球员1积分',
            'opponent_point' => '球员2积分',
            'player_challenger' => '球员1挑战者',
            'opponent_challenger' => '球员2挑战者',
            'player_quit' => '球员1退赛',
            'opponent_quit' => '球员2退赛',
            'is_invalidated' => '比赛无效',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '备注',
        ];
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
    public function getPlayer0()
    {
        return $this->hasOne(AwPlayerInformation::className(), ['id' => 'player']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpponent0()
    {
        return $this->hasOne(AwPlayerInformation::className(), ['id' => 'opponent']);
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
    public function getMatchScores()
    {
        return $this->hasMany(AwMatchScore::className(),['match_id' => 'scores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatchRound()
    {
        return $this->hasOne(AwPointType::className(),['round' => 'round']);
    }
}
