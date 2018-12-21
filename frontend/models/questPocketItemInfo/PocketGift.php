<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 14.03.2016
 */

namespace frontend\models\questPocketItemInfo;

use common\helper\ShopHelper;
use common\models\QuestPocketItem;

class PocketGift extends BaseInfo
{
    public $item_id;
    public $shop_id;
    public $name;
    public $image;
    public $count = 1;
    public $user_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'shop_id', 'name', 'count'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'ID прототипа',
            'shop_id' => 'Магазин',
            'name'    => 'Название',
            'count'   => 'Кол-во',
            'user_to' => 'Получатель',
        ];
    }

    public function getViewColumns($alias = 'info')
    {
        $labels = $this->attributeLabels();
        $columns = [
            [
                'label' => $labels['shop_id'],
                'attribute' => $alias.'.shop_id',
                'value' => ShopHelper::getShopName($this->shop_id)
            ],
            [
                'label' => 'Предмет',
                'attribute' => $alias.'.item_id',
                'value' => sprintf('%s (%d)', $this->name, $this->item_id)
            ],
            ['label' => $labels['count'], 'attribute' => $alias.'.count'],
            ['label' => $labels['user_to'], 'attribute' => $alias.'.user_to'],
        ];
        return $columns;
    }

    public function getItemType()
    {
        return QuestPocketItem::ITEM_TYPE_GIFT;
    }
}