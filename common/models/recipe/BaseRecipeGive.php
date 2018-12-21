<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:52
 */

namespace common\models\recipe;


use common\models\recipe\give\iRecipeGive;
use yii\base\Model;

abstract class BaseRecipeGive extends Model implements iRecipeGive
{
    const TYPE_EXP = 'exp';
    const TYPE_ITEM = 'item';

    /**
     * @param $type
     * @return iRecipeGive
     */
    public static function getGiveObject($type)
    {
        $type = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $className = sprintf('common\models\recipe\give\\RecipeGive%s', ucfirst($type));
        try {
            return new $className();
        } catch (\Exception $ex) {
            return null;
        }
    }
}