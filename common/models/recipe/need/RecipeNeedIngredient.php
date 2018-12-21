<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:58
 */

namespace common\models\recipe\need;


use common\models\recipe\BaseRecipeNeed;
use yii\helpers\ArrayHelper;

class RecipeNeedIngredient extends BaseRecipeNeed
{
    public $shop_id;
    public $item_id;
    public $count;
    public $item_img;
    public $item_name;

    public function getItemType()
    {
        return self::TYPE_INGREDIENT;
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
        return sprintf('Ингридиент %s в кол-ве %d', $this->item_name, $this->count);
    }
}