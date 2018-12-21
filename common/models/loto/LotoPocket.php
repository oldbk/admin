<?php

namespace common\models\loto;

use common\helper\CurrencyHelper;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "loto_pocket".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 *
 * @property LotoItem[] $lotoItems
 */
class LotoPocket extends \common\models\BaseModel
{
    private $_itemCount = null;
    private $_itemPrime = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loto_pocket';
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
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at'], 'integer'],
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
            'name' => 'Название',
            'created_at' => 'Created At',
            'itemCount' => 'Кол-во',
            'itemPrime' => 'Себестоимость',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotoItems()
    {
        return $this->hasMany(LotoItem::className(), ['pocket_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\LotoPocketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LotoPocketQuery(get_called_class());
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
            $this->setItemCount(count($this->lotoItems));
        }

        return $this->_itemCount;
    }

    public function getItemPrime()
    {
        if ($this->isNewRecord) {
            return 0;
        }

        $item_result = 0;
		$pool_count = 0;

        $count_ekr = 0;
        $cost_ekr = 0;
        foreach ($this->lotoItems as $item) {
            switch ($item->cost_type) {
                case CurrencyHelper::CURRENCY_EKR:
					$item_result += $item->cost_sum; //$item->count * $item->item_count * $item->cost => LotoItem::breforeSave()
					$pool_count += $item->count;

                	//$cost_ekr += $item->cost_sum;
                    //$count_ekr += $item->count;
                    break;
            }
        }
        
        $prime_ekr = 0;
        if($pool_count > 0) {
            $prime_ekr = $item_result / $pool_count;
        }

        return sprintf('%s екр.', Yii::$app->formatter->asDecimal($prime_ekr, 2));
    }
}
