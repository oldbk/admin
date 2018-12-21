<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace common\models\questTask;


use common\models\questTask\BaseTask;
use yii\helpers\ArrayHelper;

abstract class BaseKillTask extends BaseTask
{
    const KILL_BOT = 'kill_bot';


    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [

        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [

        ]);
    }

    public static function getTypeTitles()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            self::KILL_BOT => 'Убийство',
        ]);
    }
}