<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "gellery".
 *
 * @property integer $id
 * @property integer $owner
 * @property string $img
 * @property integer $exp_date
 * @property integer $dressed
 * @property integer $otdel
 */
class Gellery extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gellery';
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
            [['owner', 'exp_date', 'dressed', 'otdel'], 'integer'],
            [['img'], 'string', 'max' => 60],
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
            'img' => 'Img',
            'exp_date' => 'Exp Date',
            'dressed' => 'Dressed',
            'otdel' => 'Otdel',
        ];
    }

    public static function getImages($owner)
    {
        return self::find()
            ->select(['*'])
            ->where(['=','owner',$owner])
            ->createCommand()->queryAll();
    }


    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\GelleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\GelleryQuery(get_called_class());
    }
}
