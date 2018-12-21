<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wordfilter".
 *
 * @property string $id
 * @property string $word
 * @property string $created_at
 * @property string $updated_at
 */
class Wordfilter extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wordfilter';
    }


    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
		'updatedAtAttribute' => 'updated_at',
                'createdAtAttribute' => 'created_at',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
	    ['onlyfull','integer'],
            [['word'], 'string', 'max' => 255],
            [['word'], 'required','message' => 'Это обязательное поле'],
            [['word'], 'unique','message' => 'Данное слово уже есть в базе'],
	    [['word'],'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Слово',
	    'onlyfull' => 'Только полное слово',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return WordfilterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\WordfilterQuery(get_called_class());
    }
}
