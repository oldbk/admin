<?php

namespace common\models\recipe;

use common\models\ItemCategory;
use common\models\oldbk\CraftLocations;
use common\models\oldbk\CraftProf;
use common\models\oldbk\CraftRazdel;
use common\models\oldbk\NaemProto;
use Yii;

/**
 * This is the model class for table "recipe".
 *
 * @property integer $id
 * @property string $name
 * @property integer $time
 * @property integer $category_id
 * @property integer $profession_id
 * @property integer $location_id
 * @property integer $difficult
 * @property integer $is_enabled
 * @property integer $is_deleted
 * @property integer $is_vaza
 * @property integer $updated_at
 * @property integer $created_at
 * @property float $cost_profit
 * @property float $cost_need
 * @property integer $craftmfchance
 *
 * @property CraftRazdel $razdel
 * @property CraftProf $profession
 * @property CraftLocations $location
 * @property RecipeItemNeed[] $recipeItemNeed
 * @property RecipeItemGive[] $recipeItemGive
 */
class Recipe extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * @inheritdoc
     */


    public function rules()
    {
        return [
	    [['goden','unik','craftmfchance','time','difficult'],'default','value' => '0'],
            ['is_present', 
		function ($attribute, $params) {
			if ($this->$attribute) {
				if (!strlen(trim($this->present))) {
					$this->addError($attribute, 'Необходимо заполнить от кого подарком');
				}
			}
		}
            ],
	    [['time', 'category_id', 'profession_id', 'location_id', 'difficult'], 'required'],
            [['time', 'category_id', 'profession_id', 'location_id', 'difficult', 'is_enabled', 'is_vaza', 'updated_at', 'created_at', 'is_deleted', 'craftmfchance','sowner','notsell','is_present','unik','goden','naem'], 'integer'],
            [['name','present'], 'string', 'max' => 255],
	    ['present','trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'time' => 'Время выполнения (мин.)',
            'category_id' => 'Раздел',
            'profession_id' => 'Профессия',
            'location_id' => 'Локация',
            'difficult' => 'Сложность',
            'is_vaza' => 'С вазой?',
            'is_enabled' => 'Включен?',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'cost_need' => 'Затраты',
            'cost_profit' => 'Профит',
            'craftmfchance' => 'Шанс крафта шмотки в топ-мф',
            'goden' => 'Годен дней',
            'present' => 'От кого подарком',
            'is_present' => 'Подарком?',
            'sowner' => 'Привязка',
            'notsell' => 'Не для продажи',
            'unik' => 'Уник флаг',
            'naem' => 'Только для наёмников?',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\RecipeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RecipeQuery(get_called_class());
    }

    public function getRazdel()
    {
        return $this->hasOne(CraftRazdel::className(), ['id' => 'category_id']);
    }

    public function getProfession()
    {
        return $this->hasOne(CraftProf::className(), ['id' => 'profession_id']);
    }

    public function getNaemproto()
    {
        return $this->hasOne(NaemProto::className(), ['id' => 'naem']);
    }

    public function getLocation()
    {
        return $this->hasOne(CraftLocations::className(), ['id' => 'location_id']);
    }

    public function getRecipeItemNeed()
    {
        return $this->hasMany(RecipeItemNeed::className(), ['recipe_id' => 'id']);
    }

    public function getRecipeItemGive()
    {
        return $this->hasMany(RecipeItemGive::className(), ['recipe_id' => 'id']);
    }
}
