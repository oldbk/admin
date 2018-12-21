<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 14.03.2016
 */

namespace frontend\models\questPocketItemInfo;

use common\helper\ShopHelper;
use common\models\QuestPocketItem;

class PocketItem extends BaseInfo
{
    public $item_id;
    public $shop_id;
    public $name;
    public $image;
    public $count = 1;
    public $goden;
    public $maxdur;
    public $magic;
    public $present;
    public $present_text;

    public $is_present;

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
            'goden'   => 'Срок годности',
            'maxdur'  => 'Макс. долговечность',
            'magic'   => 'Магия',
            'is_present'   => 'Подарок?',
            'present' => 'От кого?',
            'present_text' => 'Текст подарка',
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
            ['label' => $labels['goden'], 'attribute' => $alias.'.goden'],
            ['label' => $labels['maxdur'], 'attribute' => $alias.'.maxdur'],
            ['label' => $labels['magic'], 'attribute' => $alias.'.magic'],
            [
                'label' => $labels['is_present'],
                'attribute' => $alias.'.is_present',
                'format' => 'raw',
                'value' => $this->getIsPresent() ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
            ],
        ];
        if($this->getIsPresent()) {
            $columns[] = ['label' => $labels['present'], 'attribute' => $alias.'.present'];
            $columns[] = ['label' => $labels['present_text'], 'attribute' => $alias.'.present_text'];
        }

        return $columns;
    }

    public function getItemType()
    {
        return QuestPocketItem::ITEM_TYPE_ITEM;
    }

    public function getIsPresent()
    {
        return $this->present ? true : false;
    }

    public function getAttributes($names = null, $except = [])
    {
        $except[] = 'is_present';

        return parent::getAttributes($names, $except);
    }
}