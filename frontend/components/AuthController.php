<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 22.03.2016
 */

namespace frontend\components;


use yii\filters\AccessControl;
use yii\web\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}