<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class BuyTask extends BaseTask
{
    public $shop_id;
    public $category_id = 0;
    public $item_id;
    public $name;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['shop_id'], 'required'],
            [['shop_id', 'category_id', 'item_id'], 'integer'],
            ['name', 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'item_id'       => 'Прототип',
            'shop_id'       => 'Магазин',
            'category_id'   => 'Раздел',
            'name'          => 'Наименование',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_BUY;
    }

    public function getViewName()
    {
        return $this->name;
    }
}