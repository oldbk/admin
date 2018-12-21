<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "top_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $description2
 * @property integer $is_enabled
 * @property string $controller
 * @property string $action
 * @property integer $updated_at
 */
class TopList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_list';
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
            [['name'], 'required'],
            [['description', 'description2'], 'string'],
            [['is_enabled', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['controller', 'action'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'description2' => 'Описание 2',
            'is_enabled' => 'Включен?',
            'controller' => 'Controller',
            'action' => 'Action',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\TopListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\TopListQuery(get_called_class());
    }
}
