<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_active".
 *
 * @property integer $id
 * @property string $time
 * @property integer $place
 * @property string $active
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 * @property boolean $is_invalidated
 *
 * @property AwArena $place0
 * @property AwIndividualActive[] $awIndividualActives
 */
class AwActive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'create_at', 'update_at'], 'safe'],
            [['place'], 'integer'],
            [['active'], 'string'],
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
            'time' => '活动时间',
            'place' => '活动地点',
            'active' => '活动详情',
            'create_at' => '记录创建时间',
            'update_at' => '记录更新时间',
            'comment' => '备注',
            'is_invalidated' => '记录无效',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace0()
    {
        return $this->hasOne(AwArena::className(), ['id' => 'place']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwIndividualActives()
    {
        return $this->hasMany(AwIndividualActive::className(), ['active' => 'id']);
    }
}
