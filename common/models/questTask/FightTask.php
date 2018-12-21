<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class FightTask extends BaseTask
{
    public $min_damage = 0;
    public $need_win = 0;
    public $fight_type = 0;
    public $fight_comment = '';
    public $enemies = '';
    public $not_enemies = '';

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['need_win', 'min_damage'], 'required'],
            [['need_win', 'min_damage'], 'integer'],
            [['fight_type', 'fight_comment', 'enemies', 'not_enemies'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'min_damage'    => 'Минимальный урон',
            'need_win'      => 'Нужна победа?',
            'fight_type'    => 'Тип боя',
            'fight_comment' => 'Комментарий боя',
            'enemies'       => 'Оппоненты',
            'not_enemies'   => 'Не должно быть в оппонентах',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_FIGHT;
    }

    public function getViewName()
    {
        return 'Бой';
    }

    public function getTitle()
    {
        return sprintf('Победа: %s<br>Тип боя: %s<br>Урон: %s<br>Коммент: %s<br>Оппоненты: %s<br>Не должны быть в оппонентах: %s',
                $this->need_win ? 'Да' : 'Нет',
                $this->fight_type > 0 ? $this->fight_type : 'Нет',
                $this->min_damage > 0 ? 'Да' : 'Нет',
                $this->fight_comment ? $this->fight_comment : '',
                $this->enemies ? $this->enemies : 'Не задано',
                $this->not_enemies ? $this->not_enemies : 'Не задано'
            );
    }
}