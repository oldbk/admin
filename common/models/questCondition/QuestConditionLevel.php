<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionLevel extends BaseCondition
{
    public $min_level;
    public $max_level;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['min_level', 'max_level'], 'required'],
            [['min_level', 'max_level'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'min_level' => 'Минимальный уровень',
            'max_level' => 'Максимальный уровень',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_LEVEL;
    }

    public function getDescription()
    {
        return sprintf('Уровни %d - %d', $this->min_level, $this->max_level);
    }
}