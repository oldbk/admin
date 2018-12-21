<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:57
 */

namespace common\models\recipe\need;


use common\models\recipe\BaseRecipeNeed;
use yii\helpers\ArrayHelper;

class RecipeNeedProfession extends BaseRecipeNeed
{
    public $profession_id;
    public $profession_name;
    public $level;

    public function getItemType()
    {
        return self::TYPE_PROFESSION;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['profession_id', 'level'], 'required'],
            [['profession_name'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'profession_id' => 'Профессия',
            'level'         => 'Уровень',
        ]);
    }

    public function getDescription()
    {
        return sprintf('Профессия %s с уровнем %d', $this->profession_name, $this->level);
    }
}