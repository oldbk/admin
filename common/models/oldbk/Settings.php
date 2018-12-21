<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "variables".
 *
 * @property string $key
 * @property string $value
 */
class Settings extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['key'], 'string', 'max' => 255],
            [['value'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => 'Var',
            'value' => 'Value',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\SettingsQuery(get_called_class());
    }
}
