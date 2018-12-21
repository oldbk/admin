<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.11.2015
 */

namespace common\helper;


class StringHelper
{
    public static function toArray($string)
    {
        if($string === null) {
            return array();
        }

        $string = unserialize($string);
        $data = $string === false ? array() : $string;

        return $data;
    }

    public static function toString(array $data)
    {
        return serialize($data);
    }
}