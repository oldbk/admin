<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\QuestValidatorItemInfo]].
 *
 * @see \common\models\QuestValidatorItemInfo
 */
class QuestValidatorItemInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\validator\QuestValidatorItemInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\validator\QuestValidatorItemInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
