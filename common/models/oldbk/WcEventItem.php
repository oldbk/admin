<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "wc_event_item".
 *
 * @property int $id
 * @property int $pocket_id
 * @property string $item_name
 * @property int $item_count
 * @property int $updated_at
 */
class WcEventItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wc_event_item';
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
            [['id', 'pocket_id', 'item_count'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pocket_id' => 'Пул',
            'item_count' => 'Кол-во',
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
