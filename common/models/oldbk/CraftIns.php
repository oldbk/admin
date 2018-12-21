<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_ins".
 *
 * @property integer $razdelid
 * @property integer $insprotoid
 */
class CraftIns extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'craft_ins';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['razdelid', 'insprotoid'], 'integer'],
            [['insprotoid'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'razdelid' => 'Razdelid',
            'insprotoid' => 'Insprotoid',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CraftInsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftInsQuery(get_called_class());
    }
}
