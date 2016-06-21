<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_individual_active".
 *
 * @property integer $id
 * @property integer $player
 * @property integer $active
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 * @property boolean $is_invalidated
 *
 * @property AwActive $active0
 * @property AwPlayerInformation $player0
 */
class AwIndividualActive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_individual_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player', 'active'], 'integer'],
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
            'player' => '球员',
            'active' => '活动',
            'create_at' => '记录创建时间',
            'update_at' => '记录更新时间',
            'comment' => '备注',
            'is_invalidated' => '记录无效',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActive0()
    {
        return $this->hasOne(AwActive::className(), ['id' => 'active']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer0()
    {
        return $this->hasOne(AwPlayerInformation::className(), ['id' => 'player']);
    }
}
