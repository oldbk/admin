<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 27.02.2016
 */

namespace common\models;


use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    const SCENARIO_SEARCH = 'search';
}