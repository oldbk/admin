<?php

namespace common\models\loto;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "loto_export".
 *
 * @property integer $id
 * @property integer $pocket_id
 * @property integer $user_id
 * @property integer $loto_num
 * @property integer $exported_at
 *
 * @property User $user
 */
class LotoExport extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loto_export';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'exported_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pocket_id', 'loto_num'], 'required'],
            [['user_id', 'exported_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'loto_num' => '№ тиража',
            'exported_at' => 'Время экспорта',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\LotoExportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LotoExportQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
