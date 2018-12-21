<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.08.16
 * Time: 21:01
 */

namespace common\models\validatorItem;


use yii\helpers\ArrayHelper;

class LocationValidator extends BaseValidator
{
    const ROOM_ALL          = 'ALL';

    
    //входы
    const ROOM_ENTER_LAB    = 45;
    const ROOM_ENTER_RUINE  = 999;

    //улица
    const ROOM_CP           = 20;

    //здания
    const ROOM_SHOP         = 22;
    const ROOM_REMONT       = 23;
    const ROOM_ELKA         = 24;
    const ROOM_COMIS        = 25;
    const ROOM_BANK         = 29;
    const ROOM_FLOWER       = 34;
    const ROOM_KLAN         = 28;
    const ROOM_BEREZA       = 35;
    const ROOM_LOTERY       = 42;
    const ROOM_LORD         = 90;
    const ROOM_DEATH_TOWER  = 10000;
    const ROOM_ZNAHAR       = 43;

    const ROOM_RUINE        = 'ruine';
    const ROOM_RUINE_ENTER  = 999;

    const ROOM_LAB_ENTER    = 45;
    const ROOM_LAB_PROSTOJ  = 'lab_1';
    const ROOM_LAB_GEROIK   = 'lab_2';
    const ROOM_LAB_NOVICHKI = 'lab_3';
    const ROOM_LAB_3D       = 'lab_4';

    const ROOM_BS_ENTER     = 10000;
    const ROOM_BS           = 'bs';

    const ROOM_ZAGA         = 'zaga';

    //комнаты
    const ROOM_TEST         = 44;


    public $room;

    public function getItemType()
    {
        return self::ITEM_TYPE_LOCATION;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            ['room', 'required'],
            [['room'], 'string']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'room' => 'Комната ID',
        ]);
    }

    public static function getRooms()
    {
        return [
            self::ROOM_ALL => 'Все',
            self::ROOM_ENTER_LAB => 'Вход в лабу',
            self::ROOM_ENTER_RUINE => 'Вход в руины',
            self::ROOM_DEATH_TOWER => 'Вход в башню смерти',

            self::ROOM_CP => 'ЦП',

            self::ROOM_SHOP => 'Гос. магазин',
            self::ROOM_REMONT => 'Ремонтка',
            self::ROOM_ELKA => 'Елка',
            self::ROOM_COMIS => 'Комиссионка',
            self::ROOM_BANK => 'Банк',
            self::ROOM_FLOWER => 'Цветочный магазин',
            self::ROOM_KLAN => 'Регистратура кланов',
            self::ROOM_BEREZA => 'Березка',
            self::ROOM_LOTERY => 'Лотерея',
            self::ROOM_LORD => 'Лорд',
            self::ROOM_ZNAHAR => 'Знахарь',

            self::ROOM_RUINE_ENTER => 'Вход в руины',
            self::ROOM_RUINE => 'Руины',

            self::ROOM_BS_ENTER => 'Вход в БС',
            self::ROOM_BS => 'БС',

            self::ROOM_LAB_ENTER => 'Лаба вход',
            self::ROOM_LAB_PROSTOJ => 'Лаба простой внутри',
            self::ROOM_LAB_GEROIK => 'Лаба героик внутри',
            self::ROOM_LAB_NOVICHKI => 'Лаба новички внутри',
            self::ROOM_LAB_3D => 'Лаба 3д внутри',

            self::ROOM_TEST => 'Тестовая комната',
            self::ROOM_ZAGA => 'Загород',
        ];
    }

    public function getDescription()
    {
        return sprintf('Комната: %s', self::getRooms()[$this->room]);
    }
}