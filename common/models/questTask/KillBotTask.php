<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class KillBotTask extends BaseKillTask
{
    public $bot_names;
    
    public $bot_id;
    public $diff_bot = 0;
    public $kill_type = self::KILL_BOT;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['bot_names'], 'string'],
            [['diff_bot'], 'integer'],
            ['bot_names', 'required'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'bot_names'    => 'Имена ботов',
            'diff_bot'  => 'Разные боты',
        ]);
    }

    public function getItemType()
    {
        return self::KILL_BOT;
    }

    public function getViewName()
    {
        return sprintf('Боты (%s)', $this->bot_names);
    }
}