<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

namespace common\rbac;


use yii\rbac\Rule;

class GuestRule extends Rule
{
    public $name = 'guest';

    public function execute($user, $item, $params)
    {
        return \Yii::$app->user->isGuest;
    }
}