<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:56
 */

namespace common\models\recipe\give;


use common\models\recipe\BaseRecipeGive;
use yii\helpers\ArrayHelper;

class RecipeGiveExp extends BaseRecipeGive
{
    public $profession_id;
    public $profession_name;
    public $count;

    public function getItemType()
    {
        return self::TYPE_EXP;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['profession_id', 'count'], 'required'],
            [['profession_name'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'profession_id' => 'Профессия',
            'count'         => 'Опыт',
        ]);
    }

    public function getDescription()
    {
        return sprintf('Выдаем опыт %d для профессии %s', $this->count, $this->profession_name);
    }
}