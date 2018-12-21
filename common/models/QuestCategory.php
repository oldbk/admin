<?php

namespace common\models;

use common\models\query\QuestCategoryQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $updated_at
 * @property integer $created_at
 */
class QuestCategory extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_category';
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
            [['name'], 'required'],
            [['updated_at', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestCategoryQuery(get_called_class());
    }
}
