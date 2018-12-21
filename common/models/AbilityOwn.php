<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ability_own".
 *
 * @property integer $magic_id
 * @property string $name
 * @property int $count
 * @property int $updated_at
 * @property int $created_at
 */
class AbilityOwn extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ability_own';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['magic_id', 'name', 'count'], 'required'],
            [['magic_id', 'count'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'magic_id' => 'ID Магии',
            'name' => 'Название реликта',
            'count' => 'Кол-во',
            'updated_at' => 'Дата обновления',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\AbilityOwnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AbilityOwnQuery(get_called_class());
    }
}
