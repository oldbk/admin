<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 06.04.2016
 */

namespace common\helper;

/**
 * Class CategoryHelper
 * @package common\helper
 *
 *
 * this file duplicate to game
 */
class CategoryDressroomHelper
{
    const CATEGORY_ITEM_NOJ = 1;
    const CATEGORY_ITEM_TOPOR = 11;
    const CATEGORY_ITEM_DUBINI = 12;
    const CATEGORY_ITEM_MECH = 13;
    const CATEGORY_ITEM_SAPOG = 2;
    const CATEGORY_ITEM_PERCHI = 21;
    const CATEGORY_ITEM_LIGHT_ARMOR = 22;
    const CATEGORY_ITEM_HEAVY_ARMOR = 23;
    const CATEGORY_ITEM_SHLEM = 24;
    const CATEGORY_ITEM_SHIT = 3;
    const CATEGORY_ITEM_SERGI = 4;
    const CATEGORY_ITEM_OGERELIE = 41;
    const CATEGORY_ITEM_KOLCA = 42;
    const CATEGORY_ITEM_TSHORT = 100;
    const CATEGORY_ITEM_CLOAK = 101;
    const CATEGORY_ITEM_RUNE = 102;

    private static $labels = [
		1 	=> 'Ножи',
		11 	=> 'Топоры',
		12 	=> 'Дубины',
		13 	=> 'Мечи',
		1000 => 'Букеты',
		2 	=> 'Обувь',
		21 	=> 'Перчатки',
		22 	=> 'Легкая броня',
		23 	=> 'Тяжелая броня',
		24 	=> 'Шлемы',
		3 	=> 'Щиты',
		4 	=> 'Серьги',
		41 	=> 'Ожерелье',
		42 	=> 'Кольца',
		100 => 'Футболки',
		101 => 'Плащи',
		102 => 'Руны',
    ];

    public static function getLabel($category_id)
    {
        return self::$labels[$category_id];
    }

    public static function getLabels()
    {
        return self::$labels;
    }
}