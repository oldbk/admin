<?php

namespace frontend\modules\dialog\controllers;

use common\models\dialog\Dialog;
use Yii;
use common\models\DialogAction;
use common\models\search\DialogActionSearch;
use frontend\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActionController implements the CRUD actions for DialogAction model.
 */
class ActionController extends AuthController
{
    /**
     * Lists all DialogQuest models.
     * @return mixed
     */
    public function actionList($id)
    {
        $searchModel = new DialogActionSearch();
        $searchModel->dialog_id = $id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 20;
        $dataProvider->pagination->route = '/dialog/action/list';

        return $this->renderPartial('ajax/_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new DialogAction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $Dialog = Dialog::findOne($id);

        $model = new DialogAction();
        $model->global_parent_id = $Dialog->global_parent_id;
        $model->dialog_id = $Dialog->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/dialog/quest/view', 'id' => $model->dialog_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DialogAction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/dialog/quest/view', 'id' => $model->dialog_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DialogAction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $dialog_id = $model->dialog_id;

        $model->delete();

        return $this->redirect(['/dialog/quest/view', 'id' => $dialog_id]);
    }

    /**
     * Finds the DialogAction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DialogAction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DialogAction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
