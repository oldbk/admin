<?php

namespace common\models;

use common\models\query\QuestQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest".
 *
 * @property integer $id
 * @property int $category_id
 * @property string $quest_type
 * @property string $name
 * @property integer $started_at
 * @property integer $ended_at
 * @property integer $min_level
 * @property integer $max_level
 * @property integer $limit_count
 * @property integer $limit_interval
 * @property integer $is_enabled
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_deleted
 * @property integer $is_canceled
 *
 * @property QuestPart[] $questParts
 * @property QuestCategory $category
 */
class Quest extends BaseModel
{
    const TYPE_DATERANGE    = 'daterange';
    const TYPE_LIMITED      = 'limited';
    const TYPE_INTERVAL     = 'interval';
    const TYPE_DAILY        = 'daily';
    const TYPE_WEEKLY       = 'weekly';

    public $daterange = null;

    private $_partCount;

    public $weight = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest';
    }

    public function init()
    {
        if($this->scenario != self::SCENARIO_SEARCH) {
            $this->started_at = 0;
            $this->ended_at = 0;

            $this->min_level = 7;
            $this->max_level = 14;

            $this->limit_count = 0;
            $this->limit_interval = 0;

            $this->is_enabled = 0;
        }

        parent::init();
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
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
            ['quest_type', 'prepareTypeAfter'],
            [['name', 'min_level', 'max_level', 'quest_type'], 'required'],
            [['started_at', 'category_id', 'ended_at', 'min_level', 'max_level', 'limit_count', 'limit_interval', 'is_enabled', 'updated_at', 'created_at', 'is_deleted', 'is_canceled'], 'integer'],
            [['name', 'quest_type'], 'string', 'max' => 255],
            [['daterange'], 'safe'],
            [['started_at', 'ended_at'], 'required', 'when' => function($model) {
                return $model->quest_type == self::TYPE_DATERANGE;
            }],
            [['limit_count'], 'required', 'when' => function($model) {
                return $model->quest_type == self::TYPE_LIMITED;
            }],
            [['limit_interval'], 'required', 'when' => function($model) {
                return $model->quest_type == self::TYPE_INTERVAL;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'started_at' => 'Started At',
            'category_id' => 'Категория',
            'ended_at' => 'Ended At',
            'min_level' => 'Min Level',
            'max_level' => 'Max Level',
            'limit_count' => 'Limit Count',
            'limit_interval' => 'Limit Interval',
            'is_enabled' => 'Включен?',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'is_deleted' => 'Is Deleted',
            'weight' => 'Вес',
            'is_canceled' => 'Отменяемый?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestParts()
    {
        return $this->hasMany(QuestPart::className(), ['quest_id' => 'id'])
                ->active();
    }

    public function getCategory()
    {
        return $this->hasOne(QuestCategory::className(), ['id' => 'category_id']);
    }

    public function setPartCount($count)
    {
        $this->_partCount = (int) $count;
    }

    /**
     * @return int
     */
    public function getPartCount()
    {
        if ($this->isNewRecord) {
            return null;
        }

        if ($this->_partCount === null) {
            $this->setPartCount(count($this->questParts));
            $weight = 0;
            foreach ($this->questParts as $part) {
                $weight += $part->weight;
            }
            $this->weight = $weight;
        }

        return $this->_partCount;
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->prepareTypeBefore();
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_DATERANGE    => 'Ограничение по времени',
            self::TYPE_LIMITED      => 'Ограничение по кол-ву',
            self::TYPE_INTERVAL     => 'Интервал',
            self::TYPE_DAILY        => 'Дневной квест',
            self::TYPE_WEEKLY       => 'Недельный квест',
        ];
    }

    protected function prepareTypeBefore()
    {
        switch ($this->quest_type) {
            case (self::TYPE_DATERANGE):
                $this->daterange = sprintf('%s - %s',
                    (new \DateTime())->setTimestamp($this->started_at)->format('d/m/Y'),
                    (new \DateTime())->setTimestamp($this->ended_at)->format('d/m/Y'));
                break;
        }
    }

    public function prepareTypeAfter()
    {
        switch ($this->quest_type) {
            case self::TYPE_INTERVAL:
            case self::TYPE_LIMITED:
            case self::TYPE_DAILY:
            case self::TYPE_WEEKLY:
                break;
            case self::TYPE_DATERANGE:

                try {
                    $date_arr = explode('-', $this->daterange);
                    if(count($date_arr) != 2) {
                        throw new \Exception;
                    }
                    $started_at_arr = explode('/', trim($date_arr[0]));
                    if(count($started_at_arr) != 3) {
                        throw new \Exception;
                    }
                    $ended_at_arr = explode('/', trim($date_arr[1]));
                    if(count($ended_at_arr) != 3) {
                        throw new \Exception;
                    }

                    $this->started_at = (new \DateTime())
                        ->setDate($started_at_arr[2], $started_at_arr[1], $started_at_arr[0])
                        ->setTime(0,0)
                        ->getTimestamp();

                    $this->ended_at = (new \DateTime())
                        ->setDate($ended_at_arr[2], $ended_at_arr[1], $ended_at_arr[0])
                        ->setTime(23,59,59)
                        ->getTimestamp();

                } catch (\Exception $ex) {
                    $this->addError('daterange', 'Некорретные даты');
                }

                break;
            default:
                $this->addError('quest_type', 'Некорректный тип квеста');
                break;
        }

        return !$this->hasErrors();
    }
}
