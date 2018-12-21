<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class DropTask extends BaseTask
{
    public $shop_id;
    public $item_id;
    public $item_ids    = null;
    public $name;
    public $is_all      = 0;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['shop_id'], 'required'],
            [['item_id'], 'required', 'when' => function($model){
                return empty($model->item_ids);
            }],
            [['item_ids'], 'required', 'when' => function($model){
                return !$model->item_id;
            }],
            [['shop_id', 'item_id', 'is_all'], 'integer'],
            ['name', 'string']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'item_id'   => 'Прототип',
            'item_ids'  => 'Прототипы',
            'shop_id'   => 'Магазин',
            'name'      => 'Наименование',
            'is_all'    => 'Все?',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_DROP;
    }

    public function getViewName()
    {
        return $this->item_id ? $this->name : 'Прототипы: '.$this->item_ids;
    }
}