<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\rateCondition;


use yii\helpers\ArrayHelper;

class RateConditionDateRang extends BaseCondition
{
	public $date_start;
	public $date_end;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['date_start', 'date_end'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'date_start' 	=> 'Дата старта',
			'date_end' 		=> 'Дата завершение',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_DATE_RANG;
    }

    public function getDescription()
    {
        return sprintf('Старт: %s.<br>Завершение: %s.', $this->date_start, $this->date_end);
    }
}