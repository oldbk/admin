<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class MagicTask extends BaseTask
{
    public $magic_id;

    public function getItemType()
    {
        return self::ITEM_TYPE_MAGIC;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['magic_id'], 'required'],
            [['magic_id'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'magic_id'  => 'Магия',
        ]);
    }

    public function getViewName()
    {
        $name = sprintf('Магия (%s).', $this->magic_id);

        return $name;
    }
}