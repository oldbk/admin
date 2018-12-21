<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\QuestValidatorItem]].
 *
 * @see \common\models\QuestValidatorItem
 */
class QuestValidatorItemQuery extends \yii\db\ActiveQuery
{
    public $parent_type;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function prepare($builder)
    {
        if ($this->parent_type !== null) {
            $this->andWhere(['parent_type' => $this->parent_type]);
        }
        return parent::prepare($builder);
    }

    /**
     * @inheritdoc
     * @return \common\models\validator\QuestValidatorItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\validator\QuestValidatorItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
