<?php

namespace common\models\event;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "event_wc_team".
 *
 * @property integer $id
 * @property string $name
 * @property string $full_flag
 * @property string $short_flag
 * @property integer $updated_at
 * @property integer $created_at
 *
 */
class EventWcTeam extends \common\models\BaseModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_wc_team';
    }

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name', 'full_flag', 'short_flag'], 'string', 'max' => 255],
			[['updated_at', 'created_at'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 			=> 'ID',
			'name' 			=> 'Название',
			'short_flag' 	=> 'Маленький флаг',
			'full_flag' 	=> 'Большой флаг',
			'updated_at' 	=> 'Обновлено',
			'created_at' 	=> 'Создано',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\query\event\EventWcTeamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\event\EventWcTeamQuery(get_called_class());
    }
}