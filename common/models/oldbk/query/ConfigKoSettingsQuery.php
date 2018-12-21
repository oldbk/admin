<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\ConfigKoSettings]].
 *
 * @see \common\models\oldbk\Variables
 */
class ConfigKoSettingsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\ConfigKoSettings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\ConfigKoSettings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
