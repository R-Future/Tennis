<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_region".
 *
 * @property integer $id
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwArena[] $awArenas
 * @property AwPlayerInformation[] $awPlayerInformations
 * @property AwPlayerInformation[] $awPlayerInformations0
 */
class AwRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'safe'],
            [['province', 'city', 'county', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => '省',
            'city' => '市',
            'county' => '县/区',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '注释',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwArenas()
    {
        return $this->hasMany(AwArena::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwPlayerInformations()
    {
        return $this->hasMany(AwPlayerInformation::className(), ['hometown' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwPlayerInformations0()
    {
        return $this->hasMany(AwPlayerInformation::className(), ['residence' => 'id']);
    }
}
