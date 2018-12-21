<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\rateCondition;


interface iCondition
{
    public function getConditionType();
    public function load($data, $formName = null);
    public function getDescription();
}