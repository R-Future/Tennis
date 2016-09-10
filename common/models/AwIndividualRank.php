<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_individual_rank".
 *
 * @property integer $id
 * @property integer $player
 * @property integer $rank_type
 * @property integer $total_points
 * @property integer $current_rank
 * @property integer $rank_lift
 * @property integer $win_matches
 * @property integer $total_matches
 * @property integer $next_week_deduct_point
 * @property integer $highest_rank
 * @property integer $no1_weeks
 * @property integer $consecutive_no1_weeks
 * @property integer $longest_no1_weeks
 * @property integer $margin_bureau
 * @property integer $year
 * @property integer $week
 * @property string $highest_rank_start_at
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
            [['player', 'total_points', 'current_rank', 'rank_lift', 'win_matches', 'total_matches', 'next_week_deduct_point', 'highest_rank', 'no1_weeks', 'consecutive_no1_weeks', 'longest_no1_weeks', 'margin_bureau','year','week'], 'integer'],
            [['highest_rank_start_at'], 'date', 'format'=>'php:Y-m-d'],
            [['rank_type'], 'integer', 'min'=>0, 'max'=>7],
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
            'rank_lift' => '排名升降',
            'win_matches' => '胜场数',
            'total_matches' => '总场数',
            'next_week_deduct_point' => '下周扣分',
            'highest_rank' => '最高排名',
            'no1_weeks' => '排名第一总周数',
            'consecutive_no1_weeks' => '连续第一周数',
            'longest_no1_weeks' => '连续第一最长周数',
            'margin_bureau' => '净胜局',
            'year' => '年份',
            'week' => '第几周',
            'highest_rank_start_at' => '最高排名开始时间',
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
