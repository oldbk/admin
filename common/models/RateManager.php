<?php

namespace common\models;

use common\models\pool\PoolAssign;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest".
 *
 * @property integer $id
 * @property string $rate_key
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $link
 * @property string $link_encicl
 * @property integer $is_enabled
 * @property string $iteration
 * @property integer $reward_till_days
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property RateManagerCondition[] $conditions
 * @property PoolAssign[] $poolAssigns
 */
class RateManager extends BaseModel
{
	const KEY_FONATN 		= 'fontan';
	const KEY_FORTUNA 		= 'fortuna';
	const KEY_ARENA 		= 'arena';
	const KEY_RUINE 		= 'ruine';
	const KEY_RISTA_ONE 	= 'rista_one';
	const KEY_DRAGON 		= 'dragon';
	const KEY_HAOS 			= 'haos';
	const KEY_OSADA 		= 'osada';
	const KEY_HELLOWEEN 	= 'helloween';

    const ITERATION_WEEKLY 		= 'weekly';
    const ITERATION_CONDITION 	= 'condition';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rate_manager';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => 'updated_at',
                'createdAtAttribute' => 'created_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate_key', 'name', 'iteration', 'reward_till_days'], 'required'],
			[['reward_till_days', 'updated_at', 'created_at'], 'integer'],
			[['rate_key', 'name', 'icon', 'link', 'link_encicl'], 'string', 'max' => 255],
			[['description'], 'string'],
			['iteration', 'in', 'range' => [self::ITERATION_WEEKLY, self::ITERATION_CONDITION]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
			'rate_key' 			=> 'Рейтинг',
            'name' 				=> 'Название',
            'description' 		=> 'Описание',
            'icon' 				=> 'Иконка',
            'link' 				=> 'Ссылка рейтинга',
            'link_encicl' 		=> 'Ссылка энциклопедии',
            'is_enabled' 		=> 'Включен?',
            'iteration' 		=> 'Частота',
            'reward_till_days' 	=> 'Награда доступна (дн.)',
            'updated_at' 		=> 'Обновлен',
            'created_at' 		=> 'Создан',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\RateManagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RateManagerQuery(get_called_class());
    }

    public function getConditions()
	{
		return $this->hasMany(RateManagerCondition::class, ['rate_id' => 'id']);
	}

    public static function getRateKeys()
	{
		return [
			self::KEY_FONATN 	=> 'Фонтан',
			self::KEY_FORTUNA 	=> 'Колесо Фортуны',
			self::KEY_ARENA 	=> 'Арена Богов',
			self::KEY_RUINE 	=> 'Руины Старого Замка',
			self::KEY_RISTA_ONE => 'Одиночные сражения Ристалища',
			self::KEY_DRAGON 	=> 'Нашествие Драконов',
			self::KEY_HAOS 		=> 'Порождение Хаоса',
			self::KEY_OSADA 	=> 'Осада замка',
			self::KEY_HELLOWEEN => 'Helloween',
		];
	}

	public static function getRateIteration()
	{
		return [
			self::ITERATION_WEEKLY 		=> 'Неделя',
			self::ITERATION_CONDITION 	=> 'По условию',
		];
	}

	public function getPoolAssigns()
	{
		return $this->hasMany(PoolAssign::class, ['target_id' => 'id'])
			->alias('poolAssigns')
			->andWhere(['=', 'poolAssigns.target_type', PoolAssign::TARGET_RATE]);
	}
}
