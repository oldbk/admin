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

class RecipeNeedStat extends BaseRecipeNeed
{
    public $sila = 0;
    public $lovk = 0;
    public $inta = 0;
    public $vinos = 0;
    public $intel = 0;
    public $mudra = 0;

    public function getItemType()
    {
        return self::TYPE_STAT;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['sila', 'lovk', 'inta', 'vinos', 'intel', 'mudra'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'sila' => 'Сила',
            'lovk' => 'Ловкость',
            'inta' => 'Интуиция',
            'vinos' => 'Выносливость',
            'intel' => 'Интеллект',
            'mudra' => 'Мудрость',
        ]);
    }

    public function getDescription()
    {
        $html = '<ul><li>СТАТЫ:</li>';
        foreach (['sila', 'lovk', 'inta', 'vinos', 'intel', 'mudra'] as $stat) {
            if($this->{$stat} == 0) {
                continue;
            }

            $html .= sprintf('<li>%s: %d</li>', $this->getAttributeLabel($stat), $this->{$stat});
        }

        $html .= '</ul>';

        return $html;
    }
}