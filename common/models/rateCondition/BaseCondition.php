<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\rateCondition;


use yii\base\Model;

abstract class BaseCondition extends Model implements iCondition
{
    const TYPE_DATE         = 'date';
    const TYPE_WEEK        	= 'week';
    const TYPE_DATE_RANG    = 'date_rang';

    public $rate_id;

	public function rules()
	{
		return [
			[['rate_id'], 'integer']
		];
	}

    /**
     * @param $type
     * @return iCondition
     * @throws \Exception
     */
    public static function createInstance($type)
    {
		$type = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $className = sprintf('\\common\\models\\rateCondition\\RateCondition%s', ucfirst($type));
        try {
            return new $className;
        } catch (\Exception $ex) {
            throw new \Exception(sprintf('Cannot find class %s', $className));
        }
    }
}