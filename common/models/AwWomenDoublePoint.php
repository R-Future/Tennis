<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_women_double_point".
 *
 * @property integer $id
 * @property integer $team
 * @property integer $year
 * @property integer $week
 * @property integer $total_matches
 * @property integer $win_matches
 * @property integer $margin_bureau
 * @property integer $point
 * @property string $create_at
 * @property string $update_at
 * @property boolean $is_invalidated
 * @property string $comment
 *
 * @property AwTeam $team0
 */
class AwWomenDoublePoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_women_double_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team', 'year', 'week', 'total_matches', 'win_matches', 'margin_bureau', 'point'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['is_invalidated'], 'boolean'],
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
            'team' => '组合',
            'year' => '年份',
            'week' => '第几周',
            'total_matches' => '总比赛场数',
            'win_matches' => '胜场数',
            'margin_bureau' => '净胜局数',
            'point' => '当周积分',
            'create_at' => '记录创建时间',
            'update_at' => '记录更新时间',
            'is_invalidated' => '记录是否无效',
            'comment' => '注释',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam0()
    {
        return $this->hasOne(AwTeam::className(), ['id' => 'team']);
    }
}
