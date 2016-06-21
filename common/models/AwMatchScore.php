<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_match_score".
 *
 * @property integer $id
 * @property string  $match_id
 * @property integer $set
 * @property integer $player1_score
 * @property integer $player2_score
 * @property integer $tie_player1_score
 * @property integer $tie_player2_score
 *
 * @property AwDoublesMatch $match
 * @property AwSinglesMatch $match0
 */
class AwMatchScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_match_score';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['set', 'player1_score', 'player2_score', 'tie_player1_score', 'tie_player2_score'], 'integer'],
            [['match_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'match_id' => '比赛',
            'set' => '盘次',
            'player1_score' => '球员1得分',
            'player2_score' => '球员2得分',
            'tie_player1_score' => '球员1抢七得分',
            'tie_player2_score' => '球员2抢七得分',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoublesMatch()
    {
        return $this->hasOne(AwDoublesMatch::className(), ['scores' => 'match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSinglesMatch()
    {
        return $this->hasOne(AwSinglesMatch::className(), ['scores' => 'match_id']);
    }
}
