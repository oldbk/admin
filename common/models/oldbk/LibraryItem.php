<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "library_item".
 *
 * @property string $id
 * @property string $pocket_id
 * @property string $item_id
 * @property integer $shop_id
 */
class LibraryItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'library_item';
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
            [['pocket_id', 'item_id', 'shop_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pocket_id' => 'Pocket ID',
            'item_id' => 'Item ID',
            'shop_id' => 'Название магазина',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\LibraryItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\LibraryItemQuery(get_called_class());
    }
}
