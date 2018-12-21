<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

use common\helper\ShopHelper;
use yii\helpers\ArrayHelper;

class ItemInfo extends BaseInfo implements iItemInfo
{
    public $is_mf = false;
    public $goden = 0;
    public $ekr_flag = 0;
    public $shop_id;
    public $item_id;
    public $item_ids;
    public $notsell = 0;
    public $is_present = 0;
    public $is_owner = 0;
    public $from_present = null;
    public $unik;
    public $ups;
    public $up_level;
    public $add_time;
    public $nclass;

    public function getItemType()
    {
        return self::ITEM_TYPE_ITEM;
    }

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
            [['shop_id', 'item_id', 'is_present', 'is_owner'], 'integer'],
            [['is_mf', 'goden', 'ekr_flag', 'notsell', 'is_present', 'from_present', 'unik', 'is_owner', 'ups', 'up_level', 'add_time', 'nclass'], 'safe'],
            [['from_present'], 'required', 'when' => function($model) {
                return $model->is_present;
            }],
            [['goden', 'ekr_flag', 'notsell', 'is_owner'], 'default', 'value' => 0]
        ]);
    }

    public function getOtherSettings()
    {
        return ($this->goden > 0 || $this->ekr_flag > 0 || $this->unik || $this->notsell > 0 || $this->is_owner > 0) ? true : false;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'item_id'       => 'Прототип',
            'item_ids'      => 'Прототипы',
            'shop_id'       => 'Магазин',
            'goden'         => 'Срок годности',
            'ekr_flag'      => 'Екр флаг',
            'is_mf'         => 'Екр МФ?',
            'is_present'    => 'Подарок?',
            'from_present'  => 'От кого?',
            'notsell'       => 'notsell',
            'unik'          => 'unik',
            'is_owner'      => 'Владелец?',
        ]);
    }

    public function getViewName()
    {
        $name = $this->name;
        if($this->is_mf) {
            $name .= ' (МФ)';
        }

        $item_ids = $this->item_id ? $this->item_id : $this->item_ids;
        $name .= ' ('.ShopHelper::getShopName($this->shop_id).' - '.$item_ids.')';

        return $name;
    }

    public function getViewLink()
    {
        return ['/item/item/show', 'item_id' => $this->item_id, 'shop_id' => $this->shop_id];
    }
}