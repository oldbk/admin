<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\QuestValidatorItemInfo]].
 *
 * @see \common\models\oldbk\QuestValidatorItemInfo
 */
class QuestValidatorItemInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\QuestValidatorItemInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\QuestValidatorItemInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
