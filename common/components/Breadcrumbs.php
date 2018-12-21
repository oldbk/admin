<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 27.02.2016
 */

namespace common\components;
use yii\base\Component;

class Breadcrumbs extends Component
{
    private $breadcrumbs = [];

    /**
     * @param $label
     * @param $route
     * @return $this
     */
    public function add($label, $route = null)
    {
        $this->breadcrumbs[] = [
            'label' => $label,
            'url'   => $route
        ];
        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->breadcrumbs;
    }
}