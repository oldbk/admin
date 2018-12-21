<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionItem extends BaseCondition
{
    public $item_prototype;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['item_prototype'], 'required'],
            [['item_prototype'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_prototype' => 'Предмет',
        ];
    }
    
    public function getConditionType()
    {
        return self::TYPE_ITEM;
    }
    
    public function getDescription()
    {
        return sprintf('Наличие предмета: %d', $this->item_prototype);
    }
}