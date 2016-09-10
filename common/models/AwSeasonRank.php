<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_season_rank".
 *
 * @property integer $id
 * @property integer $player
 * @property integer $rank_type
 * @property integer $total_points
 * @property integer $current_rank
 * @property integer $rank_lift
 * @property integer $win_matches
 * @property integer $total_matches
 * @property integer $highest_rank
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
class AwSeasonRank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_season_rank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player'], 'required'],
            [['player', 'total_points', 'current_rank', 'rank_lift', 'win_matches', 'total_matches', 'highest_rank', 'margin_bureau', 'year', 'week'], 'integer'],
            [['rank_type'], 'integer', 'min'=>5, 'max'=>6],
            [['highest_rank_start_at', 'create_at', 'update_at'], 'safe'],
            [['highest_rank_start_at'],'date','format'=>'php:Y-m-d'],
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
            'win_matches' => '当前赛季胜场数',
            'total_matches' => '当前赛季总场数',
            'highest_rank' => '最高排名',
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
