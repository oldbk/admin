<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[WordfilterException]].
 *
 * @see WordfilterException
 */
class WordfilterExceptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WordfilterException[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WordfilterException|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
