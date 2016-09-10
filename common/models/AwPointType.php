<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_point_type".
 *
 * @property integer $id
 * @property integer $tournament
 * @property integer $round
 * @property integer $winner_point
 * @property integer $loser_point
 * @property integer $penalty
 * @property string $create_at
 * @property string $update_at
 * @property boolean $is_invalidated
 * @property string $comment
 *
 * @property AwTournament $tournament0
 */
class AwPointType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_point_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tournament', 'round', 'winner_point', 'loser_point','penalty'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['is_invalidated'], 'boolean'],
            [['penalty'], 'max'=>0],
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
            'tournament' => '赛事级别',
            'round' => '轮次（0-小组赛/32-三十二强/16-十六强/8-八强/4-四强/2-决赛）',
            'winner_point' => '胜者积分',
            'loser_point' => '败者积分',
            'penalty' => '退赛处罚',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'is_invalidated' => '记录无效',
            'comment' => '注释',
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
     * @param $tournament_id
     * @return array
     */
    public function getRoundList($tournament_id){
        return $this::find()->select('round')->where(['tournament'=>$tournament_id])->indexBy('id')->column();
    }
}
