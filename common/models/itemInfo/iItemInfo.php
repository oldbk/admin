<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.03.2016
 */

namespace common\models\itemInfo;


interface iItemInfo
{
    public function getName();
    public function getTitle();
    public function getItemType();
    public function getViewName();
    public function getViewLink();
}