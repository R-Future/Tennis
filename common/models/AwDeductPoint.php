<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_deduct_point".
 *
 * @property integer $id
 * @property integer $player
 * @property integer $point
 * @property integer $entry_project
 * @property string $match_time
 * @property string $create_at
 * @property string $update_at
 * @property boolean $is_invalidated
 * @property string $comment
 *
 * @property AwPlayerInformation $player0
 */
class AwDeductPoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_deduct_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player', 'point', 'match_time', 'create_at', 'update_at', 'comment'], 'required'],
            [['player', 'point'], 'integer'],
            [['is_invalidated'], 'boolean'],
            [['point'], 'max'=>0],
            [['entry_project'], 'integer', 'min'=>0, 'max'=>7],
            [['match_time', 'create_at', 'update_at'], 'safe'],
            [['match_time'], 'date', 'format'=>'php:Y-m-d'],
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
            'player' => '球员id',
            'point' => '扣分',
            'entry_project' => '参赛类型',
            'match_time' => '比赛时间',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'is_invalidated' => '记录无效',
            'comment' => '备注',
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
