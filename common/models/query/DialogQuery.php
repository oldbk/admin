<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\QuestDialog]].
 *
 * @see \common\models\QuestDialog
 */
class DialogQuery extends \yii\db\ActiveQuery
{
    public $item_type;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function prepare($builder)
    {
        if ($this->item_type !== null) {
            $this->andWhere(['item_type' => $this->item_type]);
        }
        return parent::prepare($builder);
    }

    /**
     * @inheritdoc
     * @return \common\models\dialog\Dialog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\dialog\Dialog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
