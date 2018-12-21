<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[Wordfilter]].
 *
 * @see Wordfilter
 */
class WordfilterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Wordfilter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Wordfilter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
