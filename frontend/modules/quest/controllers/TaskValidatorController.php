<?php

namespace frontend\modules\quest\controllers;

use common\models\QuestPocketItem;
use common\models\validator\QuestValidatorItemInfo;
use common\models\validator\QuestValidatorItemTask;
use frontend\components\AuthController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class TaskValidatorController extends AuthController
{
    public function actions()
    {
        return [
            'fight'      => 'frontend\modules\quest\controllers\actions\taskValidator\FightAction',
            'location'   => 'frontend\modules\quest\controllers\actions\taskValidator\LocationAction',
            'game-enter' => 'frontend\modules\quest\controllers\actions\taskValidator\GameEnterAction',
        ];
    }

    public function actionForm($id)
    {

        return Json::encode([
            'success' => true,
            'form' => $this->renderAjax('form', ['id' => $id]),
        ]);
    }

    public function actionShow($id)
    {
        $models = QuestValidatorItemTask::find()
            ->andWhere('parent_id = :id', [':id' => $id])
            ->all();

        return Json::encode([
            'success' => true,
            'form' => $this->renderAjax('show', ['models' => $models]),
        ]);
    }

    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        //get validator
        $model = QuestValidatorItemTask::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();

        if(!$model) {
            return false;
        }
        //get task with this validator. Need for redirect to part
        $QuestTask = QuestPocketItem::find()
            ->andWhere('id = :id', [':id' => $model->item_id])
            ->one();

        try {
            QuestValidatorItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/part/view', 'id' => $QuestTask->pocket_item_id]);
    }
}
