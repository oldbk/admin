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

class RecipeNeedAlign extends BaseRecipeNeed
{
    public $aligns = null;

    public function getItemType()
    {
        return self::TYPE_ALIGN;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['aligns'], 'required'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'aligns' => 'Склоннсоть',
        ]);
    }

    public function getDescription()
    {
        return sprintf('Склонность %s', $this->aligns);
    }
}