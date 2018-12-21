<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionCount extends BaseCondition
{
	public $date_start;
	public $date_end;
    public $count;
    public $current_week;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['count'], 'required'],
            [['current_week'], 'integer'],
            [['count', 'date_start', 'date_end', 'current_week'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'date_start' => 'Дата старта мониторинга',
			'date_end' => 'Дата завершение мониторинга',
            'count' => 'Кол-во',
			'current_week' => 'В неделю',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_COUNT;
    }

    public function getDescription()
    {
        return sprintf('Лимит выполнений: %s.<br>Старт: %s.<br>Завершение: %s.<br>В неделю: %s',
			$this->count, $this->date_start ? $this->date_start : 'Не задано', $this->date_end ? $this->date_end : 'Не задано',
			$this->current_week ? 'Да' : 'Не задано');
    }
}