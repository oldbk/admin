<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\recipe\RecipeItemInfo]].
 *
 * @see \common\models\recipe\RecipeItemInfo
 */
class RecipeItemInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\recipe\RecipeItemInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\recipe\RecipeItemInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
