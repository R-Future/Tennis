<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_team".
 *
 * @property integer $id
 * @property integer $player1
 * @property integer $player2
 * @property string $start_at
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwDoublePoint[] $awDoublePoints
 * @property AwDoublesMatch[] $awDoublesMatches
 * @property AwDoublesMatch[] $awDoublesMatches0
 * @property AwPlayerInformation $player
 * @property AwPlayerInformation $player0
 */
class AwTeam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','player1','player2'], 'integer'],
            [['start_at', 'create_at', 'update_at'], 'safe'],
            [['comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'player1' => 'player1',
            'player2' => 'player2',
            'start_at' => '组合开始时间',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '备注',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwDoublePoints()
    {
        return $this->hasMany(AwDoublePoint::className(), ['team' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwDoublesMatches()
    {
        return $this->hasMany(AwDoublesMatch::className(), ['team1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwDoublesMatches0()
    {
        return $this->hasMany(AwDoublesMatch::className(), ['team2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(AwPlayerInformation::className(),['id' => 'player1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer0()
    {
        return $this->hasOne(AwPlayerInformation::className(),['id' => 'player2']);
    }
}
