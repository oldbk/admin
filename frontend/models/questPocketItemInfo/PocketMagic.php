<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 14.03.2016
 */

namespace frontend\models\questPocketItemInfo;

use common\helper\ShopHelper;
use common\models\QuestPocketItem;

class PocketMagic extends BaseInfo
{
    public $magic_id;
    public $name;
    public $count = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['magic_id', 'count'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'magic_id' => 'ID магии',
            'name'    => 'Название',
            'count'   => 'Кол-во',
        ];
    }

    public function getViewColumns($alias = 'info')
    {
        $labels = $this->attributeLabels();
        $columns = [
            [
                'label' => 'Магия',
                'attribute' => $alias.'.magic_id',
                'value' => sprintf('%s (%d)', $this->name, $this->magic_id)
            ],
            ['label' => $labels['count'], 'attribute' => $alias.'.count'],
        ];
        return $columns;
    }

    public function getItemType()
    {
        return QuestPocketItem::ITEM_TYPE_MAGIC;
    }
}