<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_lock".
 *
 * @property integer $user_id
 * @property string $ip
 * @property string $country_code
 * @property string $country_code3
 * @property string $country
 * @property string $city
 * @property integer $created_at
 * @property integer $updated_at
 *
 *
 * @property User $user
 */
class UserLock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_lock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['ip', 'country_code', 'country_code3', 'country', 'city'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'country_code' => 'Country Code',
            'country_code3' => 'Country Code3',
            'country' => 'Country',
            'city' => 'City',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\UserLockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserLockQuery(get_called_class());
    }
}
