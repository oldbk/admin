<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "magic".
 *
 * @property integer $id
 * @property string $name
 * @property integer $chanse
 * @property integer $time
 * @property string $file
 * @property integer $targeted
 * @property string $img
 * @property integer $battle_use
 * @property integer $need_block
 * @property integer $nlevel
 * @property integer $us_type
 * @property integer $target_type
 */
class Magic extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'magic';
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
            [['chanse', 'time', 'targeted', 'battle_use', 'need_block', 'nlevel', 'us_type', 'target_type'], 'integer'],
            [['img'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['file'], 'string', 'max' => 200],
            [['img'], 'string', 'max' => 100],
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
            'chanse' => 'Chanse',
            'time' => 'Time',
            'file' => 'File',
            'targeted' => 'Targeted',
            'img' => 'Img',
            'battle_use' => 'Battle Use',
            'need_block' => 'Need Block',
            'nlevel' => 'Nlevel',
            'us_type' => 'Us Type',
            'target_type' => 'Target Type',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\MagicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\MagicQuery(get_called_class());
    }
}
