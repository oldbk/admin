<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\LibraryPage]].
 *
 * @see \common\models\oldbk\LibraryPage
 */
class LibraryPageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\LibraryPage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\LibraryPage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
