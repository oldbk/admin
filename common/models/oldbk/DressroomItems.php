<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "dressroom_items".
 *
 * @property integer $item_id
 * @property integer $shop_id
 * @property integer $dressroom_shop_id
 * @property integer $category_id
 * @property integer $is_active
 * @property integer $is_mf
 * @property integer $is_unik
 * @property integer $is_uunik
 * @property integer $can_mf
 * @property integer $can_podgon
 * @property integer $can_u
 * @property integer $can_uu
 * @property integer $can_u_art
 */
class DressroomItems extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dressroom_items';
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
            [['item_id', 'dressroom_shop_id', 'shop_id', 'category_id', 'is_active', 'is_mf', 'is_unik', 'is_uunik','can_mf','can_podgon','can_u','can_uu'], 'integer'],
            [['item_id', 'dressroom_shop_id','shop_id', 'category_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 			=> 'ID',
            'item_id' 		=> 'Предмет',
            'shop_id' 		=> 'Магазин',
            'dressroom_shop_id' => 'Маг. примерочной',
            'category_id' 	=> 'Категория',
			'is_active'		=> 'В примерочной',
			'is_mf'			=> 'Модифицирован?',
			'is_unik'		=> 'Уник?',
			'is_uunik'		=> 'Улучшенный уник?',
			'can_mf'		=> 'Можно модифицировать?',
			'can_podgon'	=> 'Можно подогнать?',
			'can_u'			=> 'Можно сделать уник?',
			'can_uu'		=> 'Можно улучшить уник?',
			'can_u_art'		=> 'Можно использовать сундуки на арт?',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\DressroomItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\DressroomItemsQuery(get_called_class());
    }
}
