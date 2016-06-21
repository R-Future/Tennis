<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aw_town".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $citycode
 */
class AwTown extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aw_town';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'citycode'], 'required'],
            [['code', 'citycode'], 'string', 'max' => 6],
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
            'citycode' => 'Citycode',
        ];
    }

    /**
     * @param $province
     * @param $city
     * @return array
     * 根据省和城市获取所有区县
     */
    public function getTownList($province,$city){
        $province_code=AwProvince::findOne(['name'=>$province])['code'];
        $city_code=AwCity::findOne(['name'=>$city,'provincecode'=>$province_code])['code'];
        return $this::find()->select(['name'])->where(['citycode'=>$city_code])->indexBy('code')->column();
    }
}
