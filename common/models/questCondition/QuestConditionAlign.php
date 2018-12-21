<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionAlign extends BaseCondition
{
    public $aligns;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['aligns'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aligns' => 'Склонности',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_ALIGN;
    }

    public function getDescription()
    {
        return sprintf('Склонности "%s"', $this->aligns);
    }
}