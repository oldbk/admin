<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "library_page".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $dir
 * @property string $page_title
 * @property string $page_description
 * @property string $body
 * @property integer $is_enabled
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $order_position
 *
 * @property LibraryCategory $category
 */
class LibraryPage extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */

    const TYPE_NONE         = 0;
    const TYPE_ACTION       = 1;
    const TYPE_EVENT        = 2;
    const TYPE_QUEST        = 3;

    public static function getTypeList()
    {
        return [
            self::TYPE_NONE   	=> 'Без типа',
            self::TYPE_ACTION   => 'Акция',
            self::TYPE_EVENT    => 'Событие',
            self::TYPE_QUEST    => 'Квест',
        ];
    }


    public static function tableName()
    {
        return 'library_page';
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
            [['category_id', 'body'], 'required'],
            [['category_id', 'is_enabled', 'updated_at', 'created_at', 'order_position','type'], 'integer'],
            [['page_description', 'body','var_from','var_to'], 'string'],
            [['page_title', 'dir','var_from','var_to'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'page_title' => 'Заголовок страницы',
            'page_description' => 'Мета описание страницы',
            'body' => 'Текст',
            'is_enabled' => 'Включена?',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'dir' => 'Код обращения',
            'type' => 'Тип',
            'var_from' => 'Переменная начала',
            'var_to' => 'Переменная конца',
            'order_position' => 'Позиция',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\LibraryPageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\LibraryPageQuery(get_called_class());
    }

    public function getCategory()
    {
        return $this->hasOne(LibraryCategory::className(), ['id' => 'category_id']);
    }
}
