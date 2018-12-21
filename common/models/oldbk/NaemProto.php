<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "naem_proto".
 *
 * @property string $id
 * @property string $price
 * @property integer $pricetype
 * @property string $img
 * @property string $login
 * @property integer $sex
 * @property integer $level
 * @property integer $sila
 * @property integer $lovk
 * @property integer $inta
 * @property integer $vinos
 * @property integer $intel
 * @property integer $mudra
 * @property integer $noj
 * @property integer $mec
 * @property integer $topor
 * @property integer $dubina
 * @property integer $maxhp
 * @property integer $hp
 * @property integer $maxmana
 * @property integer $mana
 * @property string $shadow
 * @property integer $uclass
 * @property integer $is_enabled
 */
class NaemProto extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'naem_proto';
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
            [['id', 'level'], 'required'],
            [['id', 'pricetype', 'sex', 'level', 'sila', 'lovk', 'inta', 'vinos', 'intel', 'mudra', 'noj', 'mec', 'topor', 'dubina', 'maxhp', 'hp', 'maxmana', 'mana', 'uclass', 'is_enabled'], 'integer'],
            [['price'], 'number'],
            [['img', 'login'], 'string', 'max' => 255],
            [['shadow'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'pricetype' => 'Pricetype',
            'img' => 'Img',
            'login' => 'Login',
            'sex' => 'Sex',
            'level' => 'Level',
            'sila' => 'Sila',
            'lovk' => 'Lovk',
            'inta' => 'Inta',
            'vinos' => 'Vinos',
            'intel' => 'Intel',
            'mudra' => 'Mudra',
            'noj' => 'Noj',
            'mec' => 'Mec',
            'topor' => 'Topor',
            'dubina' => 'Dubina',
            'maxhp' => 'Maxhp',
            'hp' => 'Hp',
            'maxmana' => 'Maxmana',
            'mana' => 'Mana',
            'shadow' => 'Shadow',
            'uclass' => 'Uclass',
            'is_enabled' => 'Is Enabled',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\NaemProtoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\NaemProtoQuery(get_called_class());
    }
}
