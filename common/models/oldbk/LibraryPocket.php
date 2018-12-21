<?php
namespace common\models\oldbk;

use common\models\oldbk\query\LibraryPocketQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\oldbk\LibraryItem;

/**
 * This is the model class for table "library_pocket".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 *
 * @property LibraryItem[] $libraryItems
 */
class LibraryPocket extends \common\models\BaseModel
{
    private $_itemCount = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'library_pocket';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */

    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id','created_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'created_at' => 'Created At',
            'itemCount' => 'Кол-во',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getLibraryItems()
    {
        return $this->hasMany(LibraryItem::className(), ['pocket_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return LibraryPocketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LibraryPocketQuery(get_called_class());
    }

    public function setItemCount($count)
    {
        $this->_itemCount = (int) $count;
    }

    public function getItemCount()
    {
        if ($this->isNewRecord) {
            return 0;
        }

        if ($this->_itemCount === null) {
            $this->setItemCount(count($this->libraryItems));
        }

        return $this->_itemCount;
    }
}
