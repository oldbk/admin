<?php

namespace frontend\modules\quest\controllers;

use common\models\questPocket\QuestPocket;
use common\models\questPocket\QuestPocketPartReward;
use common\models\questPocket\QuestPocketPartTake;
use common\models\questPocket\QuestPocketPartTask;
use common\models\questPocket\QuestPocketPartValidate;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use frontend\components\AuthController;
use Yii;
use common\models\QuestPart;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PocketPartController extends AuthController
{
    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionReward($id)
    {
        $Part = QuestPart::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Part) {
            return false;
        }

        $model = new QuestPocketPartReward();
        $model->item_id = $Part->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
        } 

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTake($id)
    {
        $Part = QuestPart::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Part) {
            return false;
        }

        $model = new QuestPocketPartTake();
        $model->item_id = $Part->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTask($id)
    {
        $Part = QuestPart::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Part) {
            return false;
        }

        $model = new QuestPocketPartTask();
        $model->item_id = $Part->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
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
    public function actionValidate($id)
    {
        $Part = QuestPart::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Part) {
            return false;
        }

        $model = new QuestPocketPartValidate();
        $model->item_id = $Part->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
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
        $part_id = $model->item_id;

        try {
            QuestPocketItemInfo::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);
            QuestPocketItem::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/part/view', 'id' => $part_id]);
    }

    public function actionDialogFinish($id)
    {
        $model = QuestPocket::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
        }

        return $this->render('dialog', [
            'model' => $model,
        ]);
    }

    public function actionDeleteDialog($id)
    {
        $model = QuestPocket::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();

        $model->dialog_finish_id = 0;
        $model->save();

        return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
    }
}
