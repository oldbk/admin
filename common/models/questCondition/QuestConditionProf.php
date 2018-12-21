<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionProf extends BaseCondition
{
    public $profession_id;
    public $profession_name;
    public $level;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['profession_id', 'level'], 'required'],
            [['profession_id', 'level'], 'integer'],
            [['profession_id', 'level', 'profession_name'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profession_id' => 'Профессия',
            'level' => 'Уровень',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_PROF;
    }

    public function getDescription()
    {
        return sprintf('Профессия: %s. Уровень: %d', $this->profession_name, $this->level);
    }
}