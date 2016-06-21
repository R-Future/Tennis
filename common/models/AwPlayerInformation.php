<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_player_information".
 *
 * @property integer $id
 * @property string $name
 * @property string $gender
 * @property integer $age
 * @property integer $height
 * @property double $weight
 * @property string $hometown_province
 * @property string $hometown_city
 * @property string $hometown_town
 * @property string $residence_province
 * @property string $residence_city
 * @property string $residence_town
 * @property double $playing_years
 * @property string $forehand
 * @property string $backhand
 * @property double $grade
 * @property integer $singles_titles
 * @property integer $doubles_titles
 * @property string $group
 * @property string $retired
 * @property string $create_at
 * @property string $update_at
 * @property string $comment
 *
 * @property AwDoubleIndividualPoint[] $awDoubleIndividualPoints
 * @property AwIndividualRank[] $awIndividualRanks
 * @property AwMenIndividualPoint[] $awMenIndividualPoints
 * @property AwRegion $hometown0
 * @property AwRegion $residence0
 * @property AwSinglePoint[] $awSinglePoints
 * @property AwSinglesMatch[] $awSinglesMatches
 * @property AwSinglesMatch[] $awSinglesMatches0
 * @property AwWomenIndividualPoint[] $awWomenIndividualPoints
 */
class AwPlayerInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_player_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','gender', 'forehand', 'backhand'], 'required'],
            [['gender', 'forehand', 'backhand', 'group', 'retired'], 'string'],
            [['age', 'height','singles_titles','doubles_titles'], 'integer'],
            [['weight', 'playing_years', 'grade'], 'number'],
            [['create_at', 'update_at'], 'safe'],
            [['hometown_province','hometown_city','hometown_town','residence_province','residence_city','residence_town'], 'string','max'=>25],
            [['name', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'gender' => '性别',
            'age' => '年龄',
            'height' => '身高cm',
            'weight' => '体重(kg)',
            'hometown_province' => '籍贯省',
            'hometown_city' => '籍贯市',
            'hometown_town' => '籍贯区县',
            'residence_province' => '现居省',
            'residence_city' => '现居市',
            'residence_town' => '现居区县',
            'playing_years' => '球龄',
            'forehand' => '正手',
            'backhand' => '反手',
            'grade' => '级别',
            'singles_titles' => '单打冠军数',
            'doubles_titles' => '双打冠军数',
            'group' => '组别',
            'retired' => '是否退役',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'comment' => '备注',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwDoubleIndividualPoints()
    {
        return $this->hasMany(AwDoubleIndividualPoint::className(), ['player' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwIndividualRanks()
    {
        return $this->hasMany(AwIndividualRank::className(), ['player' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwMenIndividualPoints()
    {
        return $this->hasMany(AwMenIndividualPoint::className(), ['player' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwSinglePoints()
    {
        return $this->hasMany(AwSinglePoint::className(), ['player' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwSinglesMatches()
    {
        return $this->hasMany(AwSinglesMatch::className(), ['player' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwSinglesMatches0()
    {
        return $this->hasMany(AwSinglesMatch::className(), ['opponent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAwWomenIndividualPoints()
    {
        return $this->hasMany(AwWomenIndividualPoint::className(), ['player' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam(){
        return $this->hasMany(AwTeam::className(),['player1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam0(){
        return $this->hasMany(AwTeam::className(),['player2' => 'id']);
    }
}