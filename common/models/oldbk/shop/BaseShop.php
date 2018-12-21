<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 29.03.2016
 */

namespace common\models\oldbk\shop;


use common\models\BaseModel;
use common\models\oldbk\Magic;

/**
 * Class BaseShop
 * @package common\models\oldbk\shop
 *
 *
 * @property string $dressroom
 */
class BaseShop extends BaseModel
{
    public $shop_id;
    /** @var Magic */
    public $magic_model;
    /** @var Magic */
    public $include_magic_model;
}