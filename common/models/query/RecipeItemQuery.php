<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\recipe\RecipeItem]].
 *
 * @see \common\models\recipe\RecipeItem
 */
class RecipeItemQuery extends \yii\db\ActiveQuery
{
    public $operation_type;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function prepare($builder)
    {
        if ($this->operation_type !== null) {
            $this->andWhere(['operation_type' => $this->operation_type]);
        }
        return parent::prepare($builder);
    }

    /**
     * @inheritdoc
     * @return \common\models\recipe\RecipeItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\recipe\RecipeItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
