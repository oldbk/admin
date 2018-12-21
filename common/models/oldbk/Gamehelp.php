<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "gamehelp".
 *
 * @property string $id
 * @property string $name
 * @property string $dir
 * @property string $body
 */
class Gamehelp extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamehelp';
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
            [['name', 'dir', 'body'], 'required'],
            [['id','is_enabled'], 'integer'],
            [['body'], 'string'],
            [['name', 'dir'], 'string', 'max' => 255],
            [['dir'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'dir' => 'Путь',
            'body' => 'Содержимое',
            'is_enabled' => 'Включена?',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\GamehelpQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\GamehelpQuery(get_called_class());
    }
}
