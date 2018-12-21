<?php

namespace frontend\modules\quest\controllers;

use common\models\QuestPartTask;
use common\models\questPocket\QuestPocket;
use common\models\questPocket\QuestPocketTaskDo;
use common\models\questPocket\QuestPocketTaskGive;
use common\models\questPocket\QuestPocketTaskTake;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use frontend\components\AuthController;
use Yii;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PocketTaskController extends AuthController
{
    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionTake($id)
    {
        $Task = QuestPartTask::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Task) {
            return false;
        }

        $model = new QuestPocketTaskTake();
        $model->item_id = $Task->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/task/view', 'id' => $model->item_id]);
        } 

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionQuest($id)
    {
        $Task = QuestPartTask::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Task) {
            return false;
        }

        $model = new QuestPocketTaskGive();
        $model->item_id = $Task->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/task/view', 'id' => $model->item_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionDo($id)
    {
        $Task = QuestPartTask::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Task) {
            return false;
        }

        $model = new QuestPocketTaskDo();
        $model->item_id = $Task->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/task/view', 'id' => $model->item_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        $model = QuestPocket::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();

        if(!$model) {
            return false;
        }
        $task_id = $model->item_id;

        try {
            QuestPocketItemInfo::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);
            QuestPocketItem::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/task/view', 'id' => $task_id]);
    }
}
