<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_arena".
 *
 * @property integer $id
 * @property integer $region_id
 * @property string $name
 * @property string $address
 * @property string $field_type
 * @property integer $indoor_field_number
 * @property integer $outdoor_field_number
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwRegion $region
 * @property AwDoublesMatch[] $awDoublesMatches
 * @property AwSinglesMatch[] $awSinglesMatches
 */
class AwArena extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_arena';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'indoor_field_number', 'outdoor_field_number'], 'integer'],
            [['field_type'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['name', 'address', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'name' => '场馆名称',
            'address' => '场馆详细地址',
            'field_type' => '场地类型',
            'indoor_field_number' => '室内场地数量',
            'outdoor_field_number' => '室外场地数',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '注释',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(AwRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwDoublesMatches()
    {
        return $this->hasMany(AwDoublesMatch::className(), ['match_place' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwSinglesMatches()
    {
        return $this->hasMany(AwSinglesMatch::className(), ['match_place' => 'id']);
    }
}
