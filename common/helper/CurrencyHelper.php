<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.03.2016
 */

namespace common\helper;


class CurrencyHelper
{
    const CURRENCY_KR   = 1;
    const CURRENCY_EKR  = 2;
    const CURRENCY_GOLD = 3;

    public static function getCurrency()
    {
        return [
            self::CURRENCY_KR   => 'кр',
            self::CURRENCY_EKR  => 'екр',
            self::CURRENCY_GOLD  => 'монет',
        ];
    }
}