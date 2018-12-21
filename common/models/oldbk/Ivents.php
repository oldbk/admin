<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "variables".
 *
 * @property int $id
 * @property string $nazv
 * @property string $info
 * @property int $stat
 * @property string $last_finish
 * @property int $cc
 * @property int $off
 */
class Ivents extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ivents';
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
            [['nazv', 'info', 'stat', 'last_finish', 'cc', 'off'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nazv' 			=> 'Nazv',
            'info' 			=> 'Info',
            'stat' 			=> 'Stat',
            'last_finish' 	=> 'Last Finish',
            'cc' 			=> 'Cc',
            'off' 			=> 'Off',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\IventsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\IventsQuery(get_called_class());
    }
}
