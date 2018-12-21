<?php
namespace frontend\models\settings;
use \yii\base\Model;

/**
 * Signup form
 */
class SettingsDamage extends Model
{
	public $ratio_damage_tank 	= 100;
	public $ratio_damage_krit 	= 100;
	public $ratio_damage_uvorot = 100;
	public $ratio_damage_unk  	= 100;

	public function attributeLabels()
	{
		return [
			'ratio_damage_tank' 	=> 'Урон танка',
			'ratio_damage_krit' 	=> 'Урон критовика',
			'ratio_damage_uvorot' 	=> 'Урон уворота',
			'ratio_damage_unk' 		=> 'Урон всех остальных',
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ratio_damage_tank', 'ratio_damage_krit', 'ratio_damage_uvorot', 'ratio_damage_unk'], 'required'],
            [['ratio_damage_tank', 'ratio_damage_krit', 'ratio_damage_uvorot', 'ratio_damage_unk'], 'integer'],
            [['ratio_damage_tank', 'ratio_damage_krit', 'ratio_damage_uvorot', 'ratio_damage_unk'], 'safe'],
        ];
    }
}
