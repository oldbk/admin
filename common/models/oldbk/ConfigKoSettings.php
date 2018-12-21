<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "variables".
 *
 * @property int $main_id
 * @property int $group_id
 * @property string $field_name
 * @property string $field_value
 * @property string $field_type
 * @property $this[] $items
 */
class ConfigKoSettings extends \common\models\BaseModel
{
	const TYPE_DATETIMEPICKER 	= 'datetimepicker';
	const TYPE_STRING 			= 'string';
	const TYPE_ARRAY 			= 'array';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_ko_settings';
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
            [['main_id', 'field_name'], 'required'],
            [['group_id', 'field_value'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'group_id'		=> '№ Группа',
			'field_name' 	=> 'Название поле',
            'field_value' 	=> 'Значение',
            'is_enabled' 	=> 'Включена?',
        ];
    }

	public function getItems()
	{
		return $this->hasMany(ConfigKoSettings::className(), ['main_id' => 'main_id', 'group_id' => 'group_id'])
			->alias('cks');
	}

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\ConfigKoSettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\ConfigKoSettingsQuery(get_called_class());
    }
}
