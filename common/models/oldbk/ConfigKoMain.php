<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "variables".
 *
 * @property int $id
 * @property string $config_field
 * @property string $config_value
 * @property int $group
 * @property string $description
 * @property int $updated_at
 * @property int $created_at
 */
class ConfigKoMain extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_ko_main';
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
            [['title', 'description', 'is_enabled'], 'required'],
            [['updated_at', 'created_at', 'is_group'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' 		=> 'Название (для админки)',
            'description' 	=> 'Описание (для админки)',
            'is_group' 		=> 'Группа?',
            'is_enabled' 	=> 'Включена?',
            'updated_at' 	=> 'Дата обновления',
            'created_at' 	=> 'Дата создания',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\ConfigKoMainQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\ConfigKoMainQuery(get_called_class());
    }
}
