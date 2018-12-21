<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.08.16
 * Time: 21:00
 */

namespace common\models\validatorItem;


interface iValidator
{
    public function getItemType();
    public function getDescription();

}