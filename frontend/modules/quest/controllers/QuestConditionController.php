<?php

namespace frontend\modules\quest\controllers;

use common\helper\ShopHelper;
use common\models\itemInfo\ItemInfo;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Shop;
use common\models\Quest;
use common\models\QuestCondition;
use common\models\questCondition\QuestConditionItem;
use common\models\questCondition\QuestConditionMedal;
use common\models\questCondition\QuestConditionQuest;
use common\models\QuestMedal;
use common\models\questPocket\QuestPocketPartTake;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use frontend\components\AuthController;
use Yii;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class QuestConditionController extends AuthController
{
    public function actionQuest($quest_id)
    {
        $model = new QuestConditionQuest();
        if($model->load(Yii::$app->request->post())) {
            $t = Yii::$app->db->beginTransaction();
            try {
                QuestCondition::deleteAll([
                    'item_id'           => $quest_id,
                    'item_type'         => QuestCondition::ITEM_TYPE_QUEST,
                    'condition_type'    => $model->getConditionType()
                ]);

                $Quest = Quest::findOne($model->quest_id);
                $model->quest_name = $Quest->name;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'item_id'        => $quest_id,
                        'item_type'      => QuestCondition::ITEM_TYPE_QUEST,
                        'condition_type' => $model->getConditionType(),
                        'field'          => $field,
                        'value'          => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(QuestCondition::tableName(), (new QuestCondition)->attributes(), $rows)->execute();
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }

            return $this->redirect(['/quest/quest/view', 'id' => $quest_id]);
        }

        return $this->render('quest', [
            'model' => $model,
            'quest_id' => $quest_id,
        ]);
    }

    public function actionItem($quest_id)
    {
        $model = new QuestConditionItem();
        if($model->load(Yii::$app->request->post())) {
            $t = Yii::$app->db->beginTransaction();
            try {
                QuestCondition::deleteAll([
                    'item_id'           => $quest_id,
                    'item_type'         => QuestCondition::ITEM_TYPE_QUEST,
                    'condition_type'    => $model->getConditionType()
                ]);

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'item_id'        => $quest_id,
                        'item_type'      => QuestCondition::ITEM_TYPE_QUEST,
                        'condition_type' => $model->getConditionType(),
                        'field'          => $field,
                        'value'          => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(QuestCondition::tableName(), (new QuestCondition)->attributes(), $rows)->execute();
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }

            return $this->redirect(['/quest/quest/view', 'id' => $quest_id]);
        }

        return $this->render('item', [
            'model' => $model,
            'quest_id' => $quest_id,
        ]);
    }

    public function actionMedal($quest_id)
    {
        $model = new QuestConditionMedal();
        if($model->load(Yii::$app->request->post())) {
            $t = Yii::$app->db->beginTransaction();
            try {
                QuestCondition::deleteAll([
                    'item_id'           => $quest_id,
                    'item_type'         => QuestCondition::ITEM_TYPE_QUEST,
                    'condition_type'    => $model->getConditionType()
                ]);

                $Medal = QuestMedal::findOne($model->medal_key);
                $model->medal_name = $Medal->name;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'item_id'        => $quest_id,
                        'item_type'      => QuestCondition::ITEM_TYPE_QUEST,
                        'condition_type' => $model->getConditionType(),
                        'field'          => $field,
                        'value'          => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(QuestCondition::tableName(), (new QuestCondition)->attributes(), $rows)->execute();
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }

            return $this->redirect(['/quest/quest/view', 'id' => $quest_id]);
        }

        return $this->render('medal', [
            'model' => $model,
            'quest_id' => $quest_id,
        ]);
    }

    public function actionDelete($quest_id, $type)
    {
        QuestCondition::deleteAll([
            'item_id'           => $quest_id,
            'item_type'         => QuestCondition::ITEM_TYPE_QUEST,
            'condition_type'    => $type
        ]);

        return $this->redirect(['/quest/quest/view', 'id' => $quest_id]);
    }
}
