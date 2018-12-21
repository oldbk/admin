<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "plugin_analyze".
 *
 * @property integer $id
 * @property string $src
 * @property string $code
 * @property integer $is_correct
 * @property string $check_param
 * @property integer $created_at
 */
class PluginAnalyze extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plugin_analyze';
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
            [['code', 'check_param'], 'string'],
            [['is_correct', 'created_at'], 'integer'],
            [['src'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Ссылка',
            'code' => 'Code',
            'is_correct' => 'Разрешенная?',
            'check_param' => 'Check Param',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\PluginAnalyzeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\PluginAnalyzeQuery(get_called_class());
    }
}
