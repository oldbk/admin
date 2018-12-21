<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.05.2016
 */

namespace frontend\modules\dialog\controllers;


use common\models\dialog\Dialog;
use common\models\dialog\DialogPart;
use common\models\DialogAction;
use common\models\QuestPart;
use common\models\search\dialog\DialogPartSearch;
use frontend\components\AuthController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use Yii;

class PartController extends AuthController
{
    /**
     * Lists all DialogQuest models.
     * @return mixed
     */
    public function actionList($id)
    {
        $searchModel = new DialogPartSearch(['scenario' => Dialog::SCENARIO_SEARCH]);
        $searchModel->item_id = $id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 20;
        $dataProvider->pagination->route = '/dialog/part/list';
        
        return $this->renderPartial('ajax/_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DialogQuest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = DialogPart::find()
            ->andWhere('id = :id', [':id' => $id])
            ->with(['part', 'bot'])
            ->one();
        if(!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DialogQuest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $QuestPart = QuestPart::findOne($id);
        if(!$QuestPart) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new DialogPart();
        $model->item_id = $id;
        $model->global_parent_id = $QuestPart->quest_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->item_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DialogQuest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DialogQuest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $item_id = $model->item_id;
        $t = Yii::$app->db->beginTransaction();
        try {
            DialogAction::deleteAll('dialog_id = :dialog_id', [':dialog_id' => $id]);
            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/part/view', 'id' => $item_id]);
    }
    
    public function actionUp($id) 
    {
        $Dialog = $this->findModel($id);
        $PrevDialog = DialogPart::find()
            ->andWhere('global_parent_id = :global_parent_id and order_position = :position', [
                ':global_parent_id' => $Dialog->global_parent_id,
                ':position' => $Dialog->order_position - 1,
            ])
            ->one();
        if($PrevDialog) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Dialog->order_position -= 1;
                if(!$Dialog->save(false)) {
                    throw new \Exception;
                }

                $PrevDialog->order_position += 1;
                if(!$PrevDialog->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(['/quest/part/view', 'id' => $Dialog->item_id]);
    }
    
    public function actionDown($id)
    {
        $Dialog = $this->findModel($id);
        $NextDialog = DialogPart::find()
            ->andWhere('global_parent_id = :global_parent_id and order_position = :position', [
                ':global_parent_id' => $Dialog->global_parent_id,
                ':position' => $Dialog->order_position + 1,
            ])
            ->one();
        if($NextDialog) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Dialog->order_position += 1;
                if(!$Dialog->save(false)) {
                    throw new \Exception;
                }

                $NextDialog->order_position -= 1;
                if(!$NextDialog->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(['/quest/part/view', 'id' => $Dialog->item_id]);
    }

    /**
     * Finds the DialogQuest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DialogPart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DialogPart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}