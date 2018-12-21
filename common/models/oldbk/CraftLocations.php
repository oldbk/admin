<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_locations".
 *
 * @property integer $id
 * @property string $name
 * @property string $helpname
 */
class CraftLocations extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'craft_locations';
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
            [['name'], 'required'],
            [['name', 'helpname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'helpname' => 'Helpname',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CraftLocationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftLocationsQuery(get_called_class());
    }
}
