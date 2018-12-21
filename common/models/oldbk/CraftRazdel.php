<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_razdel".
 *
 * @property integer $id
 * @property integer $locationid
 * @property integer $razdel
 * @property string $name
 * @property string $desc
 */
class CraftRazdel extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'craft_razdel';
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
            [['id', 'locationid', 'razdel', 'name', 'desc'], 'required'],
            [['id', 'locationid', 'razdel'], 'integer'],
            [['rname', 'desc'], 'string', 'max' => 255],
            [['locationid', 'razdel'], 'unique', 'targetAttribute' => ['locationid', 'razdel'], 'message' => 'The combination of Locationid and Razdel has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'locationid' => 'Locationid',
            'razdel' => 'Razdel',
            'name' => 'Name',
            'desc' => 'Desc',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CraftRazdelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftRazdelQuery(get_called_class());
    }
}
