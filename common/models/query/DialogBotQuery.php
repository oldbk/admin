<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\DialogBot]].
 *
 * @see \common\models\DialogBot
 */
class DialogBotQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\DialogBot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DialogBot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
