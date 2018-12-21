<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.08.16
 * Time: 21:01
 */

namespace common\models\validatorItem;


use common\models\User;
use yii\helpers\ArrayHelper;

class UserValidator extends BaseValidator
{
    public $gender = null;
    public $level;
    public $align;


    public function getItemType()
    {
        return self::ITEM_TYPE_USER;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['gender', 'level'], 'integer'],
            [['align'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'gender'   => 'Пол',
            'level'    => 'Уровень',
            'align'    => 'Склонность',
        ]);
    }

    public function getDescription()
    {
        $gender = 'Не задан';
        $level = $this->level ? $this->level : 'Не задан';
        $align = $this->align ? $this->align : 'Не задан';

        if($this->gender !== null) {
			switch ($this->gender) {
				case User::GENDER_MALE:
					$gender = 'Мужчина';
					break;
				case User::GENDER_FEMALE:
					$gender = 'Женщина';
					break;
			}
		}

        return sprintf('Пол: %s<br>Уровень: %s<br>Склонность: %s',
            $gender, $level, $align);
    }
}