<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_city".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $provincecode
 */
class AwCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'provincecode'], 'required'],
            [['code', 'provincecode'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'provincecode' => 'Provincecode',
        ];
    }

    /**
     * @param $provence
     * @return array
     */
    public function getCityList($province){
        $province_code=AwProvince::findOne(['name'=>$province])['code'];
        return AwCity::find()->select(['name'])->where(['provincecode'=>$province_code])->indexBy('code')->column();
    }
}
