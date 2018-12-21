<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.05.2016
 */

namespace frontend\modules\dialog\controllers;


use common\models\dialog\Dialog;
use common\models\dialog\DialogQuest;
use common\models\DialogAction;
use common\models\Quest;
use common\models\search\dialog\DialogQuestSearch;
use frontend\components\AuthController;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use Yii;

class QuestController extends AuthController
{
    /**
     * Lists all DialogQuest models.
     * @return mixed
     */
    public function actionList($id, $page = 0)
    {
        $searchModel = new DialogQuestSearch(['scenario' => Dialog::SCENARIO_SEARCH]);
        $searchModel->global_parent_id = $id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 20;
        $dataProvider->pagination->route = '/dialog/quest/list';
        $dataProvider->pagination->setPage($page - 1);

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
        $model = DialogQuest::find()
            ->andWhere('id = :id', [':id' => $id])
            ->with(['quest', 'bot'])
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
        $Quest = Quest::findOne($id);
        if(!$Quest) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        $position = 1;
        $LastDialog = Dialog::find()
            ->orderBy('order_position desc')
            ->andWhere('global_parent_id = :global_parent_id', [':global_parent_id' => $id])
            ->one();
        if($LastDialog) {
            $position = $LastDialog->order_position + 1;
        }

        $model = new DialogQuest();
        $model->global_parent_id = $id;
        $model->order_position = $position;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/quest/view', 'id' => $model->global_parent_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'quest' => $Quest
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
            return $this->redirect(['/quest/quest/view', 'id' => $model->global_parent_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'quest' => $model->quest,
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
        $item_id = $model->global_parent_id;
        $t = Yii::$app->db->beginTransaction();
        try {
            DialogAction::deleteAll('dialog_id = :dialog_id', [':dialog_id' => $id]);
            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/quest/view', 'id' => $item_id]);
    }

    public function actionUp($id, $page)
    {
        $Dialog = $this->findModel($id);
        $PrevDialog = DialogQuest::find()
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

        return $this->actionList($PrevDialog->global_parent_id, $page);
    }

    public function actionDown($id, $page)
    {
        $Dialog = $this->findModel($id);
        $NextDialog = DialogQuest::find()
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

        return $this->actionList($NextDialog->global_parent_id, $page);
    }

    public function actionPosition($id)
    {
        $Dialogs = DialogQuest::find()
            ->andWhere('global_parent_id = :global_parent_id', [
                ':global_parent_id' => $id,
            ])
            ->orderBy('order_position desc')
            ->all();

        $t = Yii::$app->db->beginTransaction();
        $i = 0;
        try {
            foreach ($Dialogs as $Dialog) {
                $i++;
                $Dialog->order_position = $i;
                if(!$Dialog->save()) {
                    throw new \Exception();
                }
            }

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->actionList($id, 1);
    }

    /**
     * Finds the DialogQuest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DialogQuest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dialog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}