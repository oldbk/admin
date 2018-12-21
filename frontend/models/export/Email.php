<?php
namespace frontend\models\export;
use \yii\base\Model;

/**
 * Signup form
 */
class Email extends Model
{
	public $last_enter = 1;
	public $level = 1;

	public function attributeLabels()
	{
		return [
			'last_enter' => 'Последний вход',
			'level' => 'Уровень',
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_enter', 'level'], 'required'],
            [['last_enter', 'level'], 'integer'],
            [['last_enter', 'level'], 'safe'],
        ];
    }

    public static function getList()
	{
		return [
			1 	=> '1 день',
			3 	=> '3 дня',
			7 	=> '7 день',
			14 	=> '14 день',
			30 	=> '30 дней',
			60 	=> '60 дней',
			180 => '180 дней',
			365 => '365 дней',
		];
	}
}
