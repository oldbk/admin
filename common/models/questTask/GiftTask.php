<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class GiftTask extends BaseTask
{
    public $name;
    public $shop_id;
    public $item_id;
    public $item_ids        = null;
    public $user_to;
    public $diff_persons    = 0;
    public $only_male       = 0;
    public $only_female     = 0;
    public $only_level      = 0;
    public $align           = '';
    public $min_level;
    public $max_level;
    public $is_fshop        = 0;
    public $is_give         = 0;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['shop_id'],'required'],
            [['item_id'], 'required', 'when' => function($model){
                return empty($model->item_ids);
            }],
            [['item_ids'], 'required', 'when' => function($model){
                return !$model->item_id;
            }],
            [['shop_id','item_id', 'is_fshop', 'is_give'],'integer'],
            [['diff_persons','only_male','only_female','only_level','min_level','min_level','max_level'], 'integer'],
            [['name', 'align', 'user_to'],'string'],
            [['min_level', 'max_level'], 'required', 'when' => function($model) {
                return $model->only_level;
            }],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'item_id'       => 'Прототип',
            'item_ids'      => 'Прототипы',
            'shop_id'       => 'Магазин',
            'name'          => 'Наименование',
            'user_to'       => 'Кому подарок сделать?',
            'diff_persons'  => 'Разные персы',
            'only_male'     => 'Только мужчины',
            'only_female'   => 'Только женщины',
            'only_level'    => 'Только уровни',
            'min_level'     => 'Минимальный уровень',
            'max_level'     => 'Максимальный уровень',
            'align'         => 'Склонность через запятую',
            'is_fshop'      => 'Цветочка?',
            'is_give'       => 'Передачи?',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_GIFT;
    }

    public function getViewName()
    {
        return $this->item_id ? $this->name : 'Предметы: '.$this->item_ids;
    }
}