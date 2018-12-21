<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class EventTask extends BaseTask
{
    const EVENT_RUIN_KEY        			= 'ruin_key';
    const EVENT_RUIN_WIN        			= 'ruin_win';
    const EVENT_RUIN_DO         			= 'ruin_do';
    const EVENT_RIST_WIN        			= 'rist_win';
    const EVENT_RIST_DO         			= 'rist_do';
    const EVENT_FONTAN          			= 'fontan';
	const EVENT_FONTAN_WIN      			= 'fontan_win';
    const EVENT_RUIN_REWARD     			= 'ruin_reward';
    const EVENT_BS_WIN          			= 'bs_win';
    const EVENT_BS_DO           			= 'bs_do';
    const EVENT_BS_CHECk        			= 'bs_check';
    const EVENT_FIGHT_HIT       			= 'fight_hit';
    const EVENT_MAKE_FLOWER     			= 'make_flower';
    const EVENT_FLOWER_BOX      			= 'flower_box';
    const EVENT_LOCATION_ENTER  			= 'location_enter';
    const EVENT_REGISTRATION    			= 'registration';
    const EVENT_GIVE_SNOWBALL   			= 'give_snowball';
    const EVENT_COMMENT_ELKA    			= 'comment_elka';
    const EVENT_GAME_ENTER      			= 'game_enter';
    const EVENT_TOWN_OUT_QUEST_ANY_FINISH 	= 'town_out_quest_any_finish';
    const EVENT_LAB_QUEST_ANY_FINISH 		= 'lab_quest_any_finish';
    const EVENT_FORTUNA_ANY 				= 'fortuna_any';

    public $event_type;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['event_type'], 'required'],
            [['event_type'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'event_type'    => 'Тип события\Действия',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_EVENT;
    }

    public static function getEventNames()
    {
        return [
            self::EVENT_RUIN_KEY        			=> 'Ключ в руинах',
            self::EVENT_RUIN_WIN        			=> 'Победить в руинах',
            self::EVENT_RUIN_DO         			=> 'Учавствовать в руиннах',
            self::EVENT_RIST_WIN        			=> 'Победить в одиночном ристалище',
            self::EVENT_RIST_DO         			=> 'Учавствовать в одиночном ристалище',
            self::EVENT_FONTAN          			=> 'Бросить монетку в фонтан',
            self::EVENT_FONTAN_WIN      			=> 'Выиграть в фонтане',
            self::EVENT_RUIN_REWARD     			=> 'Взять награду из сокровищницы руин',
            self::EVENT_BS_WIN          			=> 'Выиграть в БС',
            self::EVENT_BS_DO           			=> 'Учавствовать в БС',
            self::EVENT_BS_CHECk        			=> 'Обналичить чек у Арха',
            self::EVENT_FIGHT_HIT       			=> 'Попадание в бою',
            self::EVENT_MAKE_FLOWER     			=> 'Собрать букет',
            self::EVENT_FLOWER_BOX      			=> 'Упаковать подарок',
            self::EVENT_LOCATION_ENTER  			=> 'Вход в локацию',
            self::EVENT_REGISTRATION    			=> 'Регистрация в игре',
            self::EVENT_GIVE_SNOWBALL   			=> 'Пожертвовать снежок',
            self::EVENT_COMMENT_ELKA    			=> 'Коммент на елке',
            self::EVENT_GAME_ENTER      			=> 'Вход в игру',
            self::EVENT_TOWN_OUT_QUEST_ANY_FINISH   => 'Завершить любой квест загорода',
            self::EVENT_LAB_QUEST_ANY_FINISH   		=> 'Завершить любой квест лабы',
            self::EVENT_FORTUNA_ANY   				=> 'Любой бросок в фортуне',
        ];
    }

    public function getViewName()
    {
        return self::getEventNames()[$this->event_type];
    }
}