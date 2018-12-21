<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "variables".
 *
 * @property string $var
 * @property string $value
 */
class Variables extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variables';
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
            [['var', 'value'], 'required'],
            [['var'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'var' => 'Var',
            'value' => 'Value',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\VariablesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\VariablesQuery(get_called_class());
    }
}
