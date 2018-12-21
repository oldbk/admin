<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_stats".
 *
 * @property string $owner
 * @property integer $type
 * @property string $val1
 * @property string $val2
 * @property string $val3
 * @property string $date
 * @property string $count
 * @property string $countnumeric
 */
class CraftStats extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    const CRAFT_START = 1;
    const CRAFT_EKR   = 3;
    const CRAFT_TIME  = 6;
    const CRAFT_EXP   = 7;

    public $sum_count = 0;

    public static function tableName()
    {
        return 'craft_stats';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner', 'type', 'val1', 'val2', 'val3', 'date'], 'required'],
            [['owner', 'type', 'val1', 'val2', 'val3', 'count'], 'integer'],
            [['date'], 'safe'],
            [['countnumeric'], 'number'],
            [['owner', 'type', 'val1', 'val2', 'val3', 'date'], 'unique', 'targetAttribute' => ['owner', 'type', 'val1', 'val2', 'val3', 'date'], 'message' => 'The combination of Owner, Type, Val1, Val2, Val3 and Date has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'owner' => 'Owner',
            'type' => 'Type',
            'val1' => 'Val1',
            'val2' => 'Val2',
            'val3' => 'Val3',
            'date' => 'Date',
            'count' => 'Count',
            'countnumeric' => 'Countnumeric',
        ];
    }

    /**
     * @inheritdoc
     * @return CraftStatsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftStatsQuery(get_called_class());
    }
}
