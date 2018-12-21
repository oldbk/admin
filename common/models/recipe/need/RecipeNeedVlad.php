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

class RecipeNeedVlad extends BaseRecipeNeed
{
    public $noj     = 0;
    public $topor   = 0;
    public $dubina  = 0;
    public $mech    = 0;
    public $fire    = 0;
    public $water   = 0;
    public $air     = 0;
    public $earth   = 0;
    public $light   = 0;
    public $gray    = 0;
    public $dark    = 0;

    public function getItemType()
    {
        return self::TYPE_VLAD;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['noj', 'topor', 'dubina', 'mech', 'fire', 'water', 'air', 'earth', 'light', 'gray', 'dark'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'noj'       => 'Ножи',
            'topor'     => 'Топоры',
            'dubina'    => 'Дубины',
            'mech'      => 'Мечи',
            'fire'      => 'Огонь',
            'water'     => 'Вода',
            'air'       => 'Воздух',
            'earth'     => 'Земля',
            'light'     => 'Свет',
            'gray'      => 'Серая',
            'dark'      => 'Тьма',
        ]);
    }

    public function getDescription()
    {
        $html = '<ul><li>ВЛАДЕНИЯ:</li>';
        foreach (['noj','topor','dubina','mech','fire','water','air','earth','light','gray','dark'] as $stat) {
            if($this->{$stat} == 0) {
                continue;
            }

            $html .= sprintf('<li>%s: %d</li>', $this->getAttributeLabel($stat), $this->{$stat});
        }

        $html .= '</ul>';

        return $html;
    }
}