<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionWeek extends BaseCondition
{
    public $week_id;
    public $week_name;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['week_id'], 'required'],
            [['week_id', 'week_name'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'week_id' => 'Неделя',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_WEEK;
    }

    public function getDescription()
    {
        return sprintf('Наличие недели: %s', $this->week_name);
    }
}