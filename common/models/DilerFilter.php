<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "diler_filter".
 *
 * @property integer $id
 * @property string $item_ids
 * @property string $date
 */
class DilerFilter extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diler_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_ids'], 'string'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_ids' => 'Item Ids',
            'date' => 'Date',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DilerFilterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DilerFilterQuery(get_called_class());
    }
}
