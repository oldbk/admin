<?php

namespace common\helper;

class ItemTypeHelper
{
    const TYPE_RUNE     = 30;
    const TYPE_SERGI    = 1;
    const TYPE_KULON    = 2;
    const TYPE_WEAP     = 3;
    const TYPE_BRON     = 4;
    const TYPE_RING     = 5;
    const TYPE_HELM     = 8;
    const TYPE_PERCHI   = 9;
    const TYPE_SHIT     = 10;
    const TYPE_BOOTS    = 11;
    const TYPE_SCROLL   = 12;
    const TYPE_RUBASHKA = 28; // футболки
    const TYPE_NAKIDKA  = 27; // плащи

    private static $labels = [
        self::TYPE_RUNE      => 'Руна',
        self::TYPE_SERGI     => 'Серьги',
        self::TYPE_KULON     => 'Кулон',
        self::TYPE_WEAP      => 'Оружие',
        self::TYPE_BRON      => 'Бронь',
        self::TYPE_RING      => 'Кольцо',
        self::TYPE_HELM      => 'Шлем',
        self::TYPE_PERCHI    => 'Перчатки',
        self::TYPE_SHIT      => 'Щит',
        self::TYPE_BOOTS     => 'Сапоги',
        self::TYPE_SCROLL    => 'Свиток',
        self::TYPE_RUBASHKA  => 'Футболка',
        self::TYPE_NAKIDKA   => 'Плащ',
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