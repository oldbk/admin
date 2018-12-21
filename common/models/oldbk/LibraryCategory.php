<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "library_category".
 *
 * @property integer $id
 * @property string $title
 * @property int $is_enabled
 * @property int $order_position
 */
class LibraryCategory extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'library_category';
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
            [['title'], 'string', 'max' => 255],
            [['is_enabled', 'order_position','parent'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'parent' => 'Родительский раздел',
            'is_enabled' => 'Включена?',
            'order_position' => 'Позиция',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(LibraryCategory::className(), ['id' => 'parent'])->
                from(self::tableName() . ' AS parentcategory');
    }


    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\LibraryCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\LibraryCategoryQuery(get_called_class());
    }
}
