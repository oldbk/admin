<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "loto_item_info".
 *
 * @property integer $item_id
 * @property string $field
 * @property string $value
 *
 * @property LotoItem $item
 */
class LotoItemInfo extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loto_item_info';
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
            [['item_id', 'field', 'value'], 'required'],
            [['item_id'], 'integer'],
            [['field', 'value'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LotoItem::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'field' => 'Field',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(LotoItem::className(), ['id' => 'item_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\LotoItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\LotoItemInfoQuery(get_called_class());
    }
}
