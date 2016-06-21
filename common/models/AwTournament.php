<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_tournament".
 *
 * @property integer $id
 * @property string $name
 * @property string $level
 * @property integer $prize
 * @property string $create_at
 * @property string $update_at
 * @property boolean $is_invalidated
 * @property string $comment
 *
 * @property AwDoublesMatch[] $awDoublesMatches
 * @property AwPointType[] $awPointTypes
 * @property AwSinglesMatch[] $awSinglesMatches
 */
class AwTournament extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_tournament';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prize'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['is_invalidated'], 'boolean'],
            [['name', 'level', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '赛事名称',
            'level' => '赛事级别',
            'prize' => '赛事奖金',
            'create_at' => '记录创建时间',
            'update_at' => '更新时间',
            'is_invalidated' => '记录无效',
            'comment' => '注释',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwDoublesMatches()
    {
        return $this->hasMany(AwDoublesMatch::className(), ['tournament' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwPointTypes()
    {
        return $this->hasMany(AwPointType::className(), ['tournament' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwSinglesMatches()
    {
        return $this->hasMany(AwSinglesMatch::className(), ['tournament' => 'id']);
    }

}
