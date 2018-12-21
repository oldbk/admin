<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_geo".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $country_code
 * @property string $country_code3
 * @property string $country
 * @property string $city
 * @property string $ip
 * @property integer $created_at
 */
class LogGeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_geo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['country_code', 'country_code3', 'country', 'city', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'country_code' => 'Country Code',
            'country_code3' => 'Country Code3',
            'country' => 'Country',
            'city' => 'City',
            'created_at' => 'Created At',
            'ip' => 'IP',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\LogGeoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LogGeoQuery(get_called_class());
    }
}
