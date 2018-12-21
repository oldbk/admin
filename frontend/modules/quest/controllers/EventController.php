<?php

namespace frontend\modules\quest\controllers;

use common\models\QuestEvent;
use common\models\search\QuestEventSearch;
use Yii;
use frontend\components\AuthController;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\oldbk\QuestEvent as GameQuestEvent;

/**
 * CategoryController implements the CRUD actions for QuestCategory model.
 */
class EventController extends AuthController
{
    /**
     * Lists all QuestCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new QuestCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QuestEvent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing QuestEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing QuestCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionExport($id)
    {
        $QuestEvent = QuestEvent::findOne($id);
        if(!$QuestEvent) {
            return Json::encode([
                'error' => true,
                'messages' => [
                    ['title' => 'Операция завершена с ошибкой', 'text' => 'Событие не найдено']
                ]
            ]);
        }

        $GameQuestEvent = GameQuestEvent::findOne($QuestEvent->id);
        if(!$GameQuestEvent) {
            $GameQuestEvent = new GameQuestEvent();
        }

        $GameQuestEvent->id = $QuestEvent->id;
        $GameQuestEvent->name = $QuestEvent->name;
        $GameQuestEvent->description = $QuestEvent->description;
        $GameQuestEvent->quest_ids = $QuestEvent->quest_ids;
        $GameQuestEvent->is_enabled = $QuestEvent->is_enabled;
        if(!$GameQuestEvent->save()) {
            return Json::encode([
                'error' => true,
                'messages' => [
                    ['title' => 'Операция завершена с ошибкой', 'text' => implode(', ', $GameQuestEvent->errors)]
                ]
            ]);
        }

        return Json::encode([
            'success' => true,
            'messages' => [
                ['title' => 'Операция завершена', 'text' => 'Успешно эксапортировали событие: '.$QuestEvent->name]
            ],
        ]);
    }

    /**
     * Finds the QuestCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuestEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
