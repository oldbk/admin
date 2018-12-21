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
    const TYPE_RUBASHKA = 28; // ��������
    const TYPE_NAKIDKA  = 27; // �����

    private static $labels = [
        self::TYPE_RUNE      => '����',
        self::TYPE_SERGI     => '������',
        self::TYPE_KULON     => '�����',
        self::TYPE_WEAP      => '������',
        self::TYPE_BRON      => '�����',
        self::TYPE_RING      => '������',
        self::TYPE_HELM      => '����',
        self::TYPE_PERCHI    => '��������',
        self::TYPE_SHIT      => '���',
        self::TYPE_BOOTS     => '������',
        self::TYPE_SCROLL    => '������',
        self::TYPE_RUBASHKA  => '��������',
        self::TYPE_NAKIDKA   => '����',
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