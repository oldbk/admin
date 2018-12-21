<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 00:52
 */

namespace common\models\recipe;


use common\models\recipe\need\iRecipeNeed;
use yii\base\Model;

abstract class BaseRecipeNeed extends Model implements iRecipeNeed
{
    const TYPE_ALIGN        = 'align';
    const TYPE_USER_LEVEL   = 'userLevel';
    const TYPE_PROFESSION   = 'profession';
    const TYPE_INGREDIENT   = 'ingredient';
    const TYPE_STAT         = 'stat';
    const TYPE_VLAD         = 'vlad';

    /**
     * @param $type
     * @return iRecipeNeed
     */
    public static function getNeedObject($type)
    {
        $type = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $className = sprintf('common\models\recipe\need\\RecipeNeed%s', ucfirst($type));
        try {
            return new $className();
        } catch (\Exception $ex) {
            return null;
        }
    }
}