<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.03.2016
 */

namespace common\models\questTask;


use common\models\validator\QuestValidatorItem;

interface iQuestTask
{
    public function getTitle();
    public function getItemType();
    public function getViewName();

    /**
     * @return boolean
     */
    public function hasValidatorList();

    /**
     * @return QuestValidatorItem[]
     */
    public function getValidatorList();

    /**
     * @param QuestValidatorItem $validator
     * @return mixed
     */
    public function addToValidatorList($validator);

    /**
     * @return int
     */
    public function getValidatorCount();
}