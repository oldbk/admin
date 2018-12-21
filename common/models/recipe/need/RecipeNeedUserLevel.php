<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:56
 */

namespace common\models\recipe\need;


use common\models\recipe\BaseRecipeNeed;
use yii\helpers\ArrayHelper;

class RecipeNeedUserLevel extends BaseRecipeNeed
{
    public $level = 0;

    public function getItemType()
    {
        return self::TYPE_USER_LEVEL;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['level'], 'required'],
            [['level'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'level' => 'Уровень',
        ]);
    }

    public function getDescription()
    {
        return sprintf('Уровень персонажа %d', $this->level);
    }
}