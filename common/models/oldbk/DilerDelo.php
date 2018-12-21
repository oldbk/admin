<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "dilerdelo".
 *
 * @property integer $id
 * @property integer $dilerid
 * @property string $dilername
 * @property integer $bank
 * @property string $owner
 * @property string $ekr
 * @property string $date
 * @property integer $addition
 * @property integer $order_id
 * @property string $klan
 * @property string $kof
 * @property integer $b
 * @property string $paysyst
 */
class DilerDelo extends \common\models\BaseModel
{
    const PAYSYST_QIWI          = 'qiwi';
    const PAYSYST_PAYPAL        = 'paypal';
    const PAYSYST_LIQPAY        = 'liqpay';
    const PAYSYST_MONEYONLINE   = 'moneyonline';
    const PAYSYST_WMR           = 'wmr';
    const PAYSYST_WMZ           = 'wmz';
    const PAYSYST_YANDEX        = 'yandex';
    const PAYSYST_ROBO          = 'robo';
    const PAYSYST_OKPAY         = 'okpay';

    public $sum_ekr = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dilerdelo';
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
            [['dilerid', 'bank', 'addition', 'order_id', 'b'], 'integer'],
            [['dilername', 'owner'], 'required'],
            [['ekr', 'kof'], 'number'],
            [['date'], 'safe'],
            [['dilername', 'owner', 'paysyst'], 'string', 'max' => 50],
            [['klan'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dilerid' => 'Dilerid',
            'dilername' => 'Дилер',
            'bank' => 'Bank',
            'owner' => 'Персонаж',
            'ekr' => 'Цена',
            'date' => 'Дата',
            'addition' => 'Дополнительно',
            'order_id' => 'Order ID',
            'klan' => 'Klan',
            'kof' => 'Коэф.',
            'b' => 'B',
            'paysyst' => 'Платежная система',
        ];
    }

    private static $paysystList = [
        self::PAYSYST_QIWI          => 'QIWI',
        self::PAYSYST_PAYPAL        => 'PayPal',
        self::PAYSYST_LIQPAY        => 'LiqPay',
        //self::PAYSYST_MONEYONLINE   => 'MoneyOnline',
        self::PAYSYST_WMR           => 'WMR',
        self::PAYSYST_WMZ           => 'WMZ',
        self::PAYSYST_YANDEX        => 'Yandex',
        self::PAYSYST_ROBO          => 'Robokassa',
        self::PAYSYST_OKPAY         => 'OKpay',
    ];

    public static function getPaysysts()
    {
        return self::$paysystList;
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\DilerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\DilerQuery(get_called_class());
    }
}
