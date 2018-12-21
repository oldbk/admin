<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "users_shadows".
 *
 * @property integer $id
 * @property integer $owner
 * @property integer $klan
 * @property string $name
 * @property integer $sex
 * @property integer $type
 */
class UsersShadows extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_shadows';
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
            [['owner', 'klan', 'sex', 'type'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner' => 'Owner',
            'klan' => 'Klan',
            'name' => 'Name',
            'sex' => 'Sex',
            'type' => 'Type',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\UsersShadowsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\UsersShadowsQuery(get_called_class());
    }
}
