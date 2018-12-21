<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "wc_event_bet".
 *
 * @property int $wc_event_id
 * @property int $user_id
 * @property int $res
 * @property int $is_rewarded
 * @property int $item_id
 * @property int $is_win
 * @property int $created_at
 */
class WcEventBet extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wc_event_bet';
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
            [['wc_event_id', 'user_id', 'res', 'item_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wc_event_id' => 'ID события',
            'user_id' => 'Пользователь',
            'res' => 'Результат',
            'item_id' => 'ID Горна',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\WcEventBetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\WcEventBetQuery(get_called_class());
    }
}
