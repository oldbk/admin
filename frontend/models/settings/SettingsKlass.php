<?php
namespace frontend\models\settings;
use \yii\base\Model;

/**
 * Signup form
 */
class SettingsKlass extends Model
{
	public $klass_ratio_tank_uv 	= 0.125;
	public $klass_ratio_tank_krit 	= 0.125;
	public $klass_ratio_krit_uv 	= 0.25;
	public $klass_ratio_uv_krit 	= 0.25;

	public function attributeLabels()
	{
		return [
			'klass_ratio_tank_uv' 	=> 'Уворот',
			'klass_ratio_tank_krit' => 'Крит',
			'klass_ratio_krit_uv' 	=> 'Уворот',
			'klass_ratio_uv_krit' 	=> 'Крит',
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['klass_ratio_tank_uv', 'klass_ratio_tank_krit', 'klass_ratio_krit_uv', 'klass_ratio_uv_krit'], 'required'],
            [['klass_ratio_tank_uv', 'klass_ratio_tank_krit', 'klass_ratio_krit_uv', 'klass_ratio_uv_krit'], 'safe'],
        ];
    }
}
