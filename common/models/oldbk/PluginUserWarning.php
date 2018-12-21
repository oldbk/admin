<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "plugin_user_warning".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $login
 * @property integer $count
 * @property string $data
 * @property integer $updated_at
 * @property integer $finish_interval
 * @property integer $change_host
 * @property integer $change_host_count
 * @property integer $total_check_host
 */
class PluginUserWarning extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plugin_user_warning';
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
            [['user_id'], 'required'],
            [['user_id', 'count', 'updated_at', 'finish_interval', 'change_host', 'change_host_count', 'total_check_host'], 'integer'],
            [['data'], 'string'],
            [['login'], 'string', 'max' => 255],
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
            'login' => 'Login',
            'count' => 'Кол-во предупреждений',
            'data' => 'Data',
            'updated_at' => 'Последнее обновление',
            'finish_interval' => 'Следующая проверка',
            'change_host' => 'Подмена hosts',
            'change_host_count' => 'Кол-во подмен',
            'total_check_host' => 'Всего проверок хоста',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\PluginUserWarningQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\PluginUserWarningQuery(get_called_class());
    }
}
