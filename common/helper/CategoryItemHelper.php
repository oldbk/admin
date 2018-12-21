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
class CategoryItemHelper
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

    const CATEGORY_ITEM_NEITRALNIE = 5;
    const CATEGORY_ITEM_FIGHT_ARMOR = 51;
    const CATEGORY_ITEM_SERVICE = 52;

    const CATEGORY_ITEM_LICENCE = 55;
    const CATEGORY_ITEM_AMUNICIA = 6;
    const CATEGORY_ITEM_EDA = 61;
    const CATEGORY_ITEM_MOLITVA = 60;
    const CATEGORY_ITEM_RESI = 62;
    const CATEGORY_ITEM_INSTRUMENT = 63;

    //const CATEGORY_ITEM_FLOWER_ING = 12; одинаковый с const CATEGORY_ITEM_DUBINI = 12;
    const CATEGORY_ITEM_FLOWER_READY = 14;
    const CATEGORY_ITEM_OTRKITKI = 7;
    const CATEGORY_ITEM_GIFT = 71;
    const CATEGORY_ITEM_OSEN = 76;
    const CATEGORY_ITEM_UNIK = 72;
    const CATEGORY_ITEM_SVADBA = 75;

    const CATEGORY_ITEM_SVADBA_KOLCA = 99;

    private static $labels = [
        self::CATEGORY_ITEM_NOJ => 'Ножи',
        self::CATEGORY_ITEM_TOPOR => 'Топоры',
        self::CATEGORY_ITEM_DUBINI => 'Дубины',
        self::CATEGORY_ITEM_MECH => 'Мечи',
        self::CATEGORY_ITEM_SAPOG => 'Сапоги',
        self::CATEGORY_ITEM_PERCHI => 'Перчатки',
        self::CATEGORY_ITEM_LIGHT_ARMOR => 'Легкая броня',
        self::CATEGORY_ITEM_HEAVY_ARMOR => 'Тяжелая броня',
        self::CATEGORY_ITEM_SHLEM => 'Шлем',
        self::CATEGORY_ITEM_SHIT => 'Щит',
        self::CATEGORY_ITEM_SERGI => 'Серьги',
        self::CATEGORY_ITEM_OGERELIE => 'Ожерелье',
        self::CATEGORY_ITEM_KOLCA => 'Кольца',
        self::CATEGORY_ITEM_NEITRALNIE => 'Заклятия нейтральные',
        self::CATEGORY_ITEM_FIGHT_ARMOR => 'Заклятия боевые и защитные',
        self::CATEGORY_ITEM_SERVICE => 'Заклятия сервисные',
        self::CATEGORY_ITEM_LICENCE => 'Лицензии',
        self::CATEGORY_ITEM_AMUNICIA => 'Аммуниция',
        self::CATEGORY_ITEM_EDA => 'Еда',
        self::CATEGORY_ITEM_MOLITVA => 'Молитвенные',
        self::CATEGORY_ITEM_RESI => 'Ресурсы',
        self::CATEGORY_ITEM_INSTRUMENT => 'Инструменты',

        //self::CATEGORY_ITEM_FLOWER_ING => 'Ингредиенты для букетов',
        self::CATEGORY_ITEM_FLOWER_READY => 'Готовые букеты',
        self::CATEGORY_ITEM_OTRKITKI => 'Открытки',
        self::CATEGORY_ITEM_GIFT => 'Подарки',
        self::CATEGORY_ITEM_OSEN => 'Осенние подарки',
        self::CATEGORY_ITEM_UNIK => 'Уникальные подарки',
        self::CATEGORY_ITEM_SVADBA => 'Свадебные аксессуары',
        self::CATEGORY_ITEM_SVADBA_KOLCA => 'Свадебные кольца',
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