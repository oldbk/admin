<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:56
 */

namespace common\models\recipe\give;


use common\models\recipe\BaseRecipeGive;
use yii\helpers\ArrayHelper;

class RecipeGiveItem extends BaseRecipeGive
{
    public $shop_id;
    public $item_id;
    public $item_name;
    public $count;
    public $item_img;

    public function getItemType()
    {
        return self::TYPE_ITEM;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['shop_id', 'item_id', 'count'], 'required'],
            [['shop_id', 'item_id', 'count'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'shop_id'   => 'Магазин',
            'item_id'   => 'Прототип',
            'count'     => 'Кол-во',
        ]);
    }

    public function getDescription()
    {
        return sprintf('Выдаем предмет %s в кол-ве %d', $this->item_name, $this->count);
    }
}