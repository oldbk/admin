<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 14.03.2016
 */

namespace frontend\models\questPocketItemInfo;

use common\helper\ShopHelper;
use common\models\QuestPocketItem;

class PocketBattle extends BaseInfo
{
    public $min_damage;
    public $is_win;
    public $count = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['damage', 'is_win', 'count'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'min_damage'    => 'Минимальный урон',
            'is_win'        => 'Нужна победа?',
            'count'         => 'Кол-во',
        ];
    }

    public function getViewColumns($alias = 'info')
    {
        $labels = $this->attributeLabels();
        $columns = [
            ['label' => $labels['min_damage'], 'attribute' => $alias.'.min_damage'],
            ['label' => $labels['is_win'], 'attribute' => $alias.'.is_win'],
            ['label' => $labels['count'], 'attribute' => $alias.'.count'],
        ];
        return $columns;
    }

    public function getItemType()
    {
        return QuestPocketItem::ITEM_TYPE_BATTLE;
    }
}