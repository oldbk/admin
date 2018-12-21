<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionQuest extends BaseCondition
{
    public $quest_id;
    public $quest_name;
    public $state;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['quest_id', 'state'], 'required'],
            [['quest_id', 'state', 'quest_name'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quest_id' => 'ID Квеста',
            'state' => 'Статус',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_QUEST;
    }

    public static function states()
    {
        return [
            'done'      => 'Выполнен',
            'process'   => 'В процессе',
        ];
    }

    public function getDescription()
    {
        return sprintf('Квест %s в статусе "%s"', $this->quest_name, $this->state);
    }
}