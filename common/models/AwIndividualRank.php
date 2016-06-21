<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_individual_rank".
 *
 * @property integer $id
 * @property integer $player
 * @property string $rank_type
 * @property integer $total_points
 * @property integer $current_rank
 * @property integer $highest_rank
 * @property integer $no1_weeks
 * @property integer $consecutive_no1_weeks
 * @property integer $longest_no1_weeks
 * @property integer $margin_bureau
 * @property integer $week
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwPlayerInformation $player0
 */
class AwIndividualRank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_individual_rank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player'], 'required'],
            [['player', 'total_points', 'current_rank','highest_rank', 'no1_weeks', 'consecutive_no1_weeks', 'longest_no1_weeks', 'margin_bureau','week'], 'integer'],
            [['rank_type'], 'string'],
            [['create_at', 'update_at'], 'safe'],
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
            'player' => 'Player',
            'rank_type' => '积分类型（女单，男单，混单）',
            'total_points' => '总积分',
            'current_rank' => '当前排名',
            'highest_rank' => '最高排名',
            'no1_weeks' => '排名第一总周数',
            'consecutive_no1_weeks' => '连续第一周数',
            'longest_no1_weeks' => '排名第一最长持续周数',
            'margin_bureau' => '净胜局',
            'week' => '第几周',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '注释',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer0()
    {
        return $this->hasOne(AwPlayerInformation::className(), ['id' => 'player']);
    }
}
