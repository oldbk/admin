<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionDate extends BaseCondition
{
    public $date;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['date'], 'required'],
            [['date'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Дата',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_DATE;
    }

    public function getDescription()
    {
        return sprintf('Дата %s', $this->date);
    }
}