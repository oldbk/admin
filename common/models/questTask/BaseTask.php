<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use common\models\validatorItem\iValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class BaseTask extends Model implements iQuestTask
{
    const ITEM_TYPE_DROP            = 'drop';
    const ITEM_TYPE_ITEM            = 'item';
    const ITEM_TYPE_FIGHT           = 'fight';
    const ITEM_TYPE_GIFT            = 'gift';
    const ITEM_TYPE_MAGIC           = 'magic';
    const ITEM_TYPE_HILL            = 'hill';
    const ITEM_TYPE_EVENT           = 'event';
    const ITEM_TYPE_WEIGHT          = 'weight';
    const ITEM_TYPE_BUY             = 'buy';

    public $start_count 			= 0;
    public $can_be_multiple 		= 0;

    /** @var iValidator[] */
    protected $validator_list = [];

    public static function getQuestTask($type)
    {
        $type = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $className = sprintf('common\models\questTask\\%sTask', ucfirst($type));
        try {
            return new $className();
        } catch (\Exception $ex) {
            return null;
        }
    }

	public function rules()
	{
		return ArrayHelper::merge( parent::rules(), [
			[['start_count', 'can_be_multiple'], 'integer'],
		]);
	}

	public function attributeLabels()
	{
		return ArrayHelper::merge( parent::attributeLabels(), [
			'start_count' => 'Стартовое значение',
			'can_be_multiple' => 'Может сочетаться с другими',
		]);
	}

    public function getTitle()
    {
        return static::getTypeTitles()[$this->getItemType()];
    }

    public static function getTypeTitles()
    {
        return [
            self::ITEM_TYPE_DROP    => 'Дроп',
            self::ITEM_TYPE_ITEM    => 'Предмет',
            self::ITEM_TYPE_FIGHT   => 'Бой',
            self::ITEM_TYPE_GIFT    => 'Сделать подарок',
            self::ITEM_TYPE_MAGIC   => 'Использование магии',
            self::ITEM_TYPE_EVENT   => 'Событие\Действие',
            self::ITEM_TYPE_HILL    => 'ХП по номиналу',
            self::ITEM_TYPE_WEIGHT  => 'Вес',
            self::ITEM_TYPE_BUY     => 'Покупка',
        ];
    }

    public function hasValidatorList()
    {
        return !empty($this->validator_list);
    }

    public function getValidatorList()
    {
        return $this->validator_list;
    }

    public function addToValidatorList($validator)
    {
        $this->validator_list[] = $validator;
        return $this;
    }

    public function getValidatorCount()
    {
        return count($this->validator_list);
    }
}