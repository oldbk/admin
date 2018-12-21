<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\recipe\Recipe]].
 *
 * @see \common\models\recipe\Recipe
 */
class RecipeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\recipe\Recipe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\recipe\Recipe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
