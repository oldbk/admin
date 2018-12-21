<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

use common\helper\ShopHelper;
use yii\helpers\ArrayHelper;

class CustomItemInfo extends BaseInfo
{
    public $get_method;

    public $goden = 0;
    public $ekr_flag = 0;
    public $item_id;
    //public $shop_id;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['item_id'], 'required'],
            [['is_mf', 'goden', 'ekr_flag'], 'safe'],
            [['goden', 'ekr_flag'], 'required', 'when' => function($model) {
                return $model->other_settings;
            }],
            [['goden', 'ekr_flag'], 'default', 'value' => 0]
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'item_id'   => 'Прототип',
            'goden'     => 'Срок годности',
            'ekr_flag'  => 'Екр флаг'
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_CUSTOM_ITEM;
    }

    public function getViewName()
    {
        return $this->name;
    }

    public function getViewLink()
    {
        return 'javascript:void(0)';
    }
}