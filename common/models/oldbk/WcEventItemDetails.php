<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "wc_event_item_details".
 *
 * @property int $pocket_id
 * @property int $item_id
 * @property string $field
 * @property string $value
 */
class WcEventItemDetails extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wc_event_item_details';
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
            [['pocket_id', 'item_id', 'field', 'value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pocket_id' => 'ПУл',
            'item_id' => 'Предмет',
            'field' => 'Поле',
            'value' => 'Значение',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\WcEventItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\WcEventItemQuery(get_called_class());
    }
}
