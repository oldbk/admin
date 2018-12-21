<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:55
 */

namespace common\models\recipe\need;


interface iRecipeNeed
{
    public function getItemType();

    public function getDescription();
}