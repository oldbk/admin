<?php

namespace common\models\recipe;

use common\models\query\RecipeItemQuery;
use Yii;

/**
 * This is the model class for table "recipe_item".
 *
 * @property integer $id
 * @property integer $recipe_id
 * @property string $item_type
 * @property string $operation_type
 * @property integer $updated_at
 * @property integer $created_at
 */
class RecipeItemNeed extends RecipeItem
{
    public function init()
    {
        $this->operation_type = self::OPERATION_NEED;
        parent::init();
    }

    /**
     * @return RecipeItemQuery
     */
    public static function find()
    {
        return new RecipeItemQuery(get_called_class(), ['operation_type' => self::OPERATION_NEED]);
    }

    public function beforeSave($insert)
    {
        $this->operation_type = self::OPERATION_NEED;
        return parent::beforeSave($insert);
    }
}
