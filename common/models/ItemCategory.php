<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $game_id
 * @property integer $updated_at
 * @property integer $created_at
 */
class ItemCategory extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id'], 'required'],
            [['game_id', 'updated_at', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'game_id' => 'Game ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ItemCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ItemCategoryQuery(get_called_class());
    }
}
