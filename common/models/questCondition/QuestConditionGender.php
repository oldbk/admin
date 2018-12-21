<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use common\models\User;
use yii\helpers\ArrayHelper;

class QuestConditionGender extends BaseCondition
{
    public $gender;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['gender'], 'safe'],
            [['gender'], 'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gender' => 'Пол',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_GENDER;
    }

    public function getDescription()
    {
        return sprintf('Пол "%s"', $this->gender == User::GENDER_MALE ? 'Мужской' : 'Женский');
    }
}