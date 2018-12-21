<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_prof".
 *
 * @property integer $id
 * @property string $name
 * @property string $rname
 */
class CraftProf extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'craft_prof';
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
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name', 'rname'], 'string', 'max' => 255],
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
            'rname' => 'Rname',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CraftProfQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftProfQuery(get_called_class());
    }
}
