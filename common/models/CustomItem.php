<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "custom_item".
 *
 * @property integer $id
 * @property string $name
 * @property string $get_method
 */
class CustomItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'get_method'], 'required'],
            [['name', 'get_method'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'get_method' => 'Method Validate',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CustomItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CustomItemQuery(get_called_class());
    }
}
