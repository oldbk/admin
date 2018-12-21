<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wc_event".
 *
 * @property int $id
 * @property int $year
 * @property string $team1
 * @property string $team2
 * @property int $datetime
 * @property int $team1_res
 * @property int $team2_res
 * @property int $who_win
 * @property int $updated_at
 */
class WcEvent extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wc_event';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'updatedAtAttribute' => 'updated_at',
				'createdAtAttribute' => false,
			],
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'team1', 'team2', 'datetime'], 'required'],
            [['team1', 'team2'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'team1' => 'Команда 1',
            'team2' => 'Команда 2',
            'datetime' => 'Время матча',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\WcEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\WcEventQuery(get_called_class());
    }
}
