<?php

namespace common\models\recipe;

use Yii;

/**
 * This is the model class for table "recipe_item_info".
 *
 * @property integer $item_id
 * @property integer $field
 * @property integer $value
 * @property integer $recipe_id
 */
class RecipeItemInfo extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipe_item_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'field', 'value', 'recipe_id'], 'required'],
            [['item_id', 'recipe_id'], 'integer'],
            [['field', 'value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'field' => 'Field',
            'value' => 'Value',
            'recipe_id' => 'Recipe ID',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\RecipeItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RecipeItemInfoQuery(get_called_class());
    }
}
