<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.08.16
 * Time: 21:01
 */

namespace common\models\validatorItem;


use yii\helpers\ArrayHelper;

class GameEnterValidator extends BaseValidator
{
    public $first_all;
    public $first_day;


    public function getItemType()
    {
        return self::ITEM_TYPE_GAME_ENTER;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['first_all', 'first_day'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'first_all'    => 'Впервые за все время',
            'first_day'    => 'Впервые за сутки',
        ]);
    }

    public function getDescription()
    {
        return sprintf('Впервые за все время: %s. Впервые за сутки: %s.',
            $this->first_all ? 'Да' : 'Нет', $this->first_day ? 'Да' : 'Нет');
    }
}