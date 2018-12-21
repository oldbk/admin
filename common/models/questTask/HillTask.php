<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class HillTask extends BaseTask
{
    public $hills;
    public $any_battle = 0;
    public $enemies;
    public $fight_type;
    public $fight_comment;

    public function getItemType()
    {
        return self::ITEM_TYPE_HILL;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['hills'], 'required'],
            [['hills'], 'string'],
            [['any_battle', 'hills', 'enemies', 'fight_type', 'fight_comment'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'hills'  => 'Номинал хила',
            'any_battle' => 'В любом бою',
            'enemies' => 'Опоненты',
        ]);
    }

    public function getViewName()
    {
        $name = sprintf('Хилл (%s).', $this->hills);
        if($this->any_battle) {
            $name .= ' В любом бою.';
        }
        if($this->enemies) {
            $name .= ' Опоненты: '.$this->enemies;
        }
        if($this->fight_type) {
            $name .= ' Тип боя: '.$this->fight_type;
        }
        if($this->fight_comment) {
            $name .= ' Коммент боя: '.$this->fight_comment;
        }

        return $name;
    }
}