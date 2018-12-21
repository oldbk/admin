<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\LibraryPocket]].
 *
 * @see \common\models\oldbk\LibraryPocket
 */
class LibraryPocketQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return \common\models\oldbk\LibraryPocket[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\LibraryPocket|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
