<?php

namespace frontend\modules\quest\controllers;

use common\models\oldbk\QuestPartItem;
use common\models\Quest;
use common\models\QuestCondition;
use common\models\questCondition\BaseCondition;
use common\models\QuestPartTask;
use common\models\QuestPocket;
use frontend\components\AuthController;
use Yii;
use common\models\QuestPart;
use common\models\search\QuestPartSearch;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PartController extends AuthController
{
    /**
     * @param $id
     * @return string
     */
    public function actionList($id)
    {
        $searchModel = new QuestPartSearch(['scenario' => Quest::SCENARIO_SEARCH]);
        $searchModel->quest_id = $id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;
        $dataProvider->pagination->route = '/quest/part/list';
        $dataProvider->sort->defaultOrder = ['part_number' => SORT_ASC];

        return $this->renderPartial('ajax/_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QuestPart model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = QuestPart::find()
            ->andWhere('id = :id', [':id' => $id])
            ->with([
                'quest',
                'pocketRewards',
                'pocketTasks',
            ])->one();

        $Models = QuestCondition::find()
            ->where('item_id = :item_id', [':item_id' => $id])
            ->part()
            ->all();

        $types = [];
        foreach ($Models as $Model) {
            $types[$Model->group][$Model->condition_type][$Model->field] = $Model->value;
        }

        $List = [];
        $i = 1;
        foreach ($types as $group => $raws) {
            foreach ($raws as $condition_type => $data) {
                $Condition = BaseCondition::createInstance($condition_type);
                $Condition->load($data, '');

                $List[] = [
                    'id' => $i,
                    'name' => $Condition->getDescription(),
                    'type' => $Condition->getConditionType(),
                    'group' => $group
                ];
                $i++;
            }
        }

        $provider = new ArrayDataProvider([
            'allModels' => $List,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'provider' => $provider,
        ]);
    }

    /**
     * @param $id
     * @return bool|string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $Quest = Quest::find()
            ->active()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Quest) {
            //@TODO error
            return false;
        }

        $model = new QuestPart();
        $model->quest_id = $Quest->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'quest' => $Quest
            ]);
        }
    }

    /**
     * Updates an existing QuestPart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $Quest = Quest::find()
            ->active()
            ->andWhere('id = :id', [':id' => $model->quest_id])
            ->one();
        if(!$Quest) {
            //@TODO error
            return false;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/quest/part/view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'quest' => $Quest
            ]);
        }
    }

    /**
     * Deletes an existing QuestPart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        $model = $this->findModel($id);
        try {

            $model->is_deleted = true;
            $model->save();

            QuestPart::updateAll(['is_deleted' => 1, 'updated_at' => time()], 'id = :id', [':id' => $id]);

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/quest/view', 'id' => $model->quest_id]);
    }

    public function actionUp($id)
    {
        $Part = $this->findModel($id);
        $PrevPart = QuestPart::find()
            ->andWhere('quest_id = :quest_id and part_number = :position', [
                ':quest_id' => $Part->quest_id,
                ':position' => $Part->part_number - 1,
            ])
            ->one();
        if($PrevPart) {
            $t = Yii::$app->db->beginTransaction();
            try {

                $Part->part_number -= 1;
                if(!$Part->save(false)) {
                    throw new \Exception;
                }

                $PrevPart->part_number += 1;
                if(!$PrevPart->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionDown($id)
    {
        $Part = $this->findModel($id);
        $NextPart = QuestPart::find()
            ->andWhere('quest_id = :quest_id and part_number = :position', [
                ':quest_id' => $Part->quest_id,
                ':position' => $Part->part_number + 1,
            ])
            ->one();
        if($NextPart) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Part->part_number += 1;
                if(!$Part->save(false)) {
                    throw new \Exception;
                }

                $NextPart->part_number -= 1;
                if(!$NextPart->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionPosition($id)
    {
        $Parts = QuestPart::find()
            ->andWhere('quest_id = :quest_id', [
                ':quest_id' => $id,
            ])
            ->orderBy('part_number desc')
            ->all();

        $t = Yii::$app->db->beginTransaction();
        $i = 0;
        try {
            foreach ($Parts as $Part) {
                $i++;
                $Part->part_number = $i;
                if(!$Part->save()) {
                    throw new \Exception();
                }
            }

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(Yii::$app->request->getReferrer());
    }

    /**
     * Finds the QuestPart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestPart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuestPart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
