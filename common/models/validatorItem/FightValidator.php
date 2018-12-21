<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.08.16
 * Time: 21:01
 */

namespace common\models\validatorItem;


use yii\helpers\ArrayHelper;

class FightValidator extends BaseValidator
{
    public $type;
    public $comment;
    public $enemies; //противники
    public $helpers; //помощники
    public $need_win = 0;
    public $min_damage = 0;


    public function getItemType()
    {
        return self::ITEM_TYPE_FIGHT;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['need_win', 'min_damage'], 'integer'],
            [['comment', 'enemies', 'helpers'], 'string'],
            ['type', 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'type'       => 'Тип',
            'comment'    => 'Комментарий',
            'enemies'    => 'Противники',
            'helpers'    => 'Помощники',
            'need_win'   => 'Нужна победа?',
            'min_damage' => 'Урон'
        ]);
    }

    public function getDescription()
    {
        return sprintf('Тип: %s. Коммент: %s. Противники: %s. Помощники: %s. Нужна победа: %s. Минмальный урон: %d',
            $this->type, $this->comment, $this->enemies, $this->helpers, $this->need_win ? 'Да' : 'Нет', $this->min_damage);
    }
}