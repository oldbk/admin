<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "loto_item".
 *
 * @property integer $id
 * @property integer $loto_num
 * @property integer $category_id
 * @property integer $count
 * @property integer $use_count
 * @property integer $stock
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $cost_kr
 * @property integer $cost_ekr
 * @property string $item_name
 *
 * @property LotoItemInfo[] $lotoItemInfos
 */
class LotoItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loto_item';
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
            [['item_name', 'category_id'], 'required'],
            [['cost_ekr', 'cost_kr'], 'safe'],
            [['loto_num', 'count', 'stock', 'updated_at', 'created_at', 'use_count', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loto_num' => 'Loto Num',
            'stock' => 'Stock',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotoItemInfos()
    {
        return $this->hasMany(LotoItemInfo::className(), ['item_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\LotoItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\LotoItemQuery(get_called_class());
    }
}
