<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class ItemTask extends BaseTask
{
    public $shop_id;
    public $item_id;
    public $name;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['shop_id', 'item_id'], 'required'],
            [['shop_id', 'item_id'], 'integer'],
            ['name', 'string']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'item_id'   => 'Прототип',
            'shop_id'   => 'Магазин',
            'name'      => 'Наименование',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_ITEM;
    }

    public function getViewName()
    {
        return $this->name;
    }
}