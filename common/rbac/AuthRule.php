<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

namespace common\rbac;


use yii\rbac\Rule;

class AuthRule extends Rule
{
    public $name = 'user';

    public function execute($user, $item, $params)
    {
        return !\Yii::$app->user->isGuest;
    }
}