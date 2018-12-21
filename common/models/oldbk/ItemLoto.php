<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "item_loto".
 *
 * @property integer $id
 * @property integer $loto
 * @property integer $owner
 * @property string $saletime
 * @property integer $dil
 * @property string $lotodate
 * @property integer $win
 * @property integer $item_id
 * @property integer $shop_id
 */
class ItemLoto extends \common\models\BaseModel
{
    public $ticket_count = 0;
    public $sum_kr = 0;
    public $sum_ekr = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_loto';
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
            [['loto', 'owner', 'dil', 'win', 'item_id', 'shop_id'], 'integer'],
            [['saletime'], 'safe'],
            [['lotodate'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loto' => 'Loto',
            'owner' => 'Owner',
            'saletime' => 'Saletime',
            'dil' => 'Dil',
            'lotodate' => 'Lotodate',
            'win' => 'Win',
            'item_id' => 'Item ID',
            'shop_id' => 'Shop ID',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\ItemLotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\ItemLotoQuery(get_called_class());
    }
}
