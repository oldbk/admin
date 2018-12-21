<?php

namespace frontend\modules\quest\controllers;

use common\models\dialog\Dialog;
use common\models\DialogAction;
use common\models\Notepad;
use common\models\oldbk\QuestList as GameQuestList;
use common\models\oldbk\QuestPart as GameQuestPart;
use common\models\oldbk\QuestPocket as GameQuestPocket;
use common\models\oldbk\QuestPocketItem as GameQuestPocketItem;
use common\models\oldbk\QuestPocketItemInfo as GameQuestPocketItemInfo;
use common\models\oldbk\QuestDialog as GameDialog;
use common\models\oldbk\QuestDialogAction as GameDialogAction;
use common\models\validator\QuestValidatorItem;
use common\models\validator\QuestValidatorItemInfo;
use common\models\oldbk\UserQuestPartItem as GameUserQuestPartItem;
use common\models\oldbk\QuestCondition as GameQuestCondition;
use common\models\oldbk\QuestValidatorItem as GameQuestValidatorItem;
use common\models\oldbk\QuestValidatorItemInfo as GameQuestValidatorItemInfo;

use common\models\QuestCondition;
use common\models\questCondition\BaseCondition;
use common\models\QuestPart;
use common\models\questPocket\QuestPocket;
use common\models\QuestPocketItem;
use common\models\search\QuestSearch;
use frontend\components\AuthController;
use GuzzleHttp\Client;
use Yii;
use common\models\Quest;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestController implements the CRUD actions for QuestList model.
 */
class QuestController extends AuthController
{
    /**
     * Lists all Quest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestSearch(['scenario' => Quest::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->with('questParts');

        $Notepad = Notepad::find()
            ->andWhere('place = :place', [':place' => Notepad::PLACE_QUEST])
            ->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notepad' => $Notepad,
        ]);
    }

    /**
     * Displays a single QuestList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $Models = QuestCondition::find()
            ->where('item_id = :item_id', [':item_id' => $id])
            ->quest()
            ->all();

        $types = [];
        foreach ($Models as $Model) {
            $types[$Model->group][$Model->condition_type][$Model->field] = $Model->value;
        }

        $List = [];
        $i = 1;
        foreach ($types as $group => $raws) {
            foreach ($raws as $condition_type => $data) {
                $model = BaseCondition::createInstance($condition_type);
                $model->load($data, '');

                $List[] = [
                    'id' => $i,
                    'name' => $model->getDescription(),
                    'type' => $model->getConditionType(),
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
            'model' => $this->findModel($id),
            'provider' => $provider
        ]);
    }

    /**
     * Creates a new QuestList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing QuestList model.
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
     * Deletes an existing QuestList model.
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

            QuestPart::updateAll([
                'is_deleted' => true,
                'updated_at' => time()
            ], 'quest_id = :quest_id', [':quest_id' => $model->id]);

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/quest/index']);
    }

    public function actionExport($id)
    {
        $Quest = Quest::find()
            ->andWhere('id = :id', [':id' => $id])
            ->with([
                'questParts' => function($query){
                    $query->active();
                },
                'questParts.pocketRewards',
                'questParts.pocketRewards.pocketItems',
                'questParts.pocketRewards.pocketItems.itemInfo',

                'questParts.pocketTasks',
                'questParts.pocketTasks.pocketItems',
                'questParts.pocketTasks.pocketItems.itemInfo',
            ])
            ->one();

        $t = GameQuestList::getDb()->beginTransaction();
        try {
            $QuestList = GameQuestList::find()
                ->andWhere('id = :id', [':id' => $id])
                ->one();
            if(!$QuestList) {
                $QuestList = new GameQuestList();
                $QuestList->id = $id;
            }

            $QuestList->quest_type = $Quest->quest_type;
            $QuestList->name = $Quest->name;
            $QuestList->started_at = $Quest->started_at;
            $QuestList->ended_at = $Quest->ended_at;
            $QuestList->min_level = $Quest->min_level;
            $QuestList->max_level = $Quest->max_level;
            $QuestList->limit_count = $Quest->limit_count;
            $QuestList->limit_interval = $Quest->limit_interval;
            $QuestList->is_enabled = $Quest->is_enabled;
            $QuestList->is_canceled = $Quest->is_canceled;
            if(!$QuestList->save()) {
                throw new \Exception('Не удалось сохранить квест');
            }

            GameQuestCondition::deleteAll('item_id = :item_id and item_type = :item_type',
                [
                    ':item_id' => $Quest->id,
                    ':item_type' => QuestCondition::ITEM_TYPE_QUEST
                ]);
            $QuestCondition = QuestCondition::find()
                ->andWhere('item_id = :item_id', [':item_id' => $Quest->id])
                ->quest()
                ->all();
            foreach ($QuestCondition as $Condition) {
                $GameCondition = new GameQuestCondition();
                $GameCondition->group = $Condition->group;
                $GameCondition->item_id = $Condition->item_id;
                $GameCondition->item_type = $Condition->item_type;
                $GameCondition->condition_type = $Condition->condition_type;
                $GameCondition->field = $Condition->field;
                $GameCondition->value = $Condition->value;
                if(!$GameCondition->save()) {
                    throw new \Exception('Не удалось сохранить условие по квесту');
                }
            }

			GameQuestValidatorItemInfo::deleteAll(['and',
				'global_parent_id = :global_parent_id'
			], [':global_parent_id' => $Quest->id]);
			GameQuestValidatorItem::deleteAll(['and',
				'global_parent_id = :global_parent_id'
			], [':global_parent_id' => $Quest->id]);
            GameQuestPocketItemInfo::deleteAll(['and',
                'global_parent_id = :global_parent_id'
            ], [':global_parent_id' => $Quest->id]);
            GameQuestPocketItem::deleteAll(['and',
                'global_parent_id = :global_parent_id'
            ], [':global_parent_id' => $Quest->id]);
            GameQuestPocket::deleteAll(['and',
                'global_parent_id = :global_parent_id'
            ], [':global_parent_id' => $Quest->id]);
			GameQuestPart::updateAll([
				'is_deleted' => true,
				'updated_at' => time()
			], 'quest_id = :quest_id', [':quest_id' => $Quest->id]);

            foreach ($Quest->questParts as $Part) {
                $QuestPart = GameQuestPart::find()
                    ->andWhere('id = :id', [':id' => $Part->id])
                    ->one();
                if(!$QuestPart) {
                    $QuestPart = new GameQuestPart();
                    $QuestPart->id = $Part->id;
                    $QuestPart->quest_id = $Part->quest_id; //ID квеста в игре
                }

                $QuestPart->name = $Part->name;
                $QuestPart->img = $Part->img;
                $QuestPart->description_type = $Part->description_type;
                $QuestPart->description_data = $Part->description;
                $QuestPart->chat_start = $Part->chat_start;
                $QuestPart->chat_end = $Part->chat_end;
                $QuestPart->is_auto_finish = $Part->is_auto_finish;
                $QuestPart->is_auto_start = $Part->is_auto_start;
                $QuestPart->part_number = $Part->part_number;

                if(!$QuestPart->isNewRecord && $Part->is_deleted == 1) {
					GameUserQuestPartItem::updateAll(
                		['is_deleted' => 1],
						'quest_part_id = :quest_part_id',
						[':quest_part_id' => $QuestPart->id]
					);
				}

				$QuestPart->is_deleted = $Part->is_deleted;
                $QuestPart->weight = $Part->weight;
                $QuestPart->complete_condition_message = $Part->complete_condition_message;
                if(!$QuestPart->save()) {
                    throw new \Exception('Не удалось сохранить часть');
                }

                GameQuestCondition::deleteAll('item_id = :item_id and item_type = :item_type',
                    [
                        ':item_id' => $Part->id,
                        ':item_type' => QuestCondition::ITEM_TYPE_PART
                    ]);
                $PartCondition = QuestCondition::find()
                    ->andWhere('item_id = :item_id', [':item_id' => $Part->id])
                    ->part()
                    ->all();
                foreach ($PartCondition as $Condition) {
                    $GameCondition = new GameQuestCondition();
                    $GameCondition->group = $Condition->group;
                    $GameCondition->item_id = $Condition->item_id;
                    $GameCondition->item_type = $Condition->item_type;
                    $GameCondition->condition_type = $Condition->condition_type;
                    $GameCondition->field = $Condition->field;
                    $GameCondition->value = $Condition->value;
                    if(!$GameCondition->save()) {
                        throw new \Exception('Не удалось сохранить условие части');
                    }
                }

                $pocket_ids = [];
                foreach ($Part->pocketRewards as $Pocket) {
                    $pocket_ids[] = $Pocket->id;
                }
                foreach ($Part->pocketTasks as $Pocket) {
                    $pocket_ids[] = $Pocket->id;
                }
                foreach ($Part->pocketTakes as $Pocket) {
                    $pocket_ids[] = $Pocket->id;
                }

                $item_ids = [];
                //Награда за часть
                $item_ids[] = ArrayHelper::merge($item_ids, $this->addPocketWithItem($Quest->id, $Part->pocketRewards));
                //Изымаемое
                $item_ids[] = ArrayHelper::merge($item_ids, $this->addPocketWithItem($Quest->id, $Part->pocketTakes));
                //Задания
                $item_ids[] = ArrayHelper::merge($item_ids, $this->addPocketWithItem($Quest->id, $Part->pocketTasks));

                GameUserQuestPartItem::deleteAll(['and',
                    'quest_id = :quest_id',
                    'quest_part_id = :quest_part_id',
                    ['not in', 'item_id', $item_ids]
                ], [':quest_id' => $Quest->id, ':quest_part_id' => $Part->id]);
            }

            //Dialogs
            $Dialogs = Dialog::find()
                ->andWhere('global_parent_id = :global_parent_id', [
                    ':global_parent_id' => $Quest->id
                ])
                ->andWhere(['in', 'item_type', [Dialog::TYPE_PART, Dialog::TYPE_QUEST]])
                ->all();
            
            GameDialogAction::deleteAll('global_parent_id = :global_parent_id', [':global_parent_id' => $Quest->id]);
            GameDialog::deleteAll('global_parent_id = :global_parent_id', [':global_parent_id' => $Quest->id]);

            $dialog_ids = [];
            foreach ($Dialogs as $Dialog) {
                $GameDialog = new GameDialog();
                $GameDialog->id = $Dialog->id;
                $GameDialog->global_parent_id = $Dialog->global_parent_id;
                $GameDialog->bot_id = $Dialog->bot_id;
                $GameDialog->item_id = $Dialog->item_id;
                $GameDialog->item_type = $Dialog->item_type;
                $GameDialog->action_type = $Dialog->action_type;
                $GameDialog->message = $Dialog->message;
                $GameDialog->is_saved = $Dialog->is_saved;
                $GameDialog->order_position = $Dialog->order_position;
                $GameDialog->next_save_dialog = $Dialog->next_save_dialog;
                $GameDialog->location = $Dialog->location;
                if(!$GameDialog->save()) {
                    throw new \Exception('Не удалось сохранить диалог');
                }

                $dialog_ids[] = $Dialog->id;
            }

            $DialogActions = DialogAction::find()
                ->andWhere(['in', 'dialog_id', $dialog_ids])
                ->all();
            foreach ($DialogActions as $Action) {
                $GameDialogAction = new GameDialogAction();
                $GameDialogAction->id = $Action->id;
                $GameDialogAction->global_parent_id = $Quest->id;
                $GameDialogAction->dialog_id = $Action->dialog_id;
                $GameDialogAction->item_id = $Action->item_id;
                $GameDialogAction->item_type = $Action->item_type;
                $GameDialogAction->next_dialog_id = $Action->next_dialog_id;
                $GameDialogAction->message = $Action->message;
                if(!$GameDialogAction->save()) {
                    throw new \Exception('Не удалось сохранить ответ на диалог.');
                }
            }

            $t->commit();

            $client = new Client();
            $res = $client->request('GET', 'http://capitalcity.oldbk.com/action/api/questCache?quest_id='.$Quest->id);
            $data = Json::decode($res->getBody()->getContents());
            if(!isset($data['status']) || $data['status'] == 0) {
                return Json::encode([
                    'error' => true,
                    'messages' => [
                        [
                            'title' => 'Операция завершена. Экспорт квеста',
                            'text' => 'Успешно экспортировали квест'
                        ],
                        [
                            'title' => 'Операция завершена с ошибкой',
                            'text' => isset($data['message']) ? $data['message'] : 'Возникли проблемы при инвалидации кэша',
                        ]
                    ]
                ]);
            }

            return Json::encode([
                'success' => true,
                'messages' => [
                    [
                        'title' => 'Операция завершена. Экспорт квеста',
                        'text' => 'Успешно экспортировали квест'
                    ],
                    [
                        'title' => 'Инвалидация кэша для квеста',
                        'text' => $data['message']
                    ],
                ],
            ]);
        } catch (\Exception $ex) {
            $t->rollBack();

            return Json::encode([
                'error' => true,
                'messages' => [
                    [
                        'title' => 'Операция завершена с ошибкой',
                        'text' => $ex->getMessage(),
                        'debug' => $ex->getTraceAsString(),
                    ]
                ]
            ]);
        }
    }

    /**
     * @param $quest_id
     * @param QuestPocket[] $Pockets
     * @return array
     * @throws \Exception
     */
    private function addPocketWithItem($quest_id, $Pockets)
    {
        $item_ids = [];
        foreach ($Pockets as $Pocket) {
            $GamePocket = GameQuestPocket::find()
                ->andWhere('id = :id', [':id' => $Pocket->id])
                ->one();
            if(!$GamePocket) {
                $GamePocket = new GameQuestPocket();
                $GamePocket->id = $Pocket->id;
                $GamePocket->global_parent_id = $quest_id;
            }

            $GamePocket->item_id = $Pocket->item_id;
            $GamePocket->item_type = $Pocket->item_type;
            $GamePocket->condition = $Pocket->condition;
            $GamePocket->dialog_finish_id = $Pocket->dialog_finish_id;
            if(!$GamePocket->save()) {
                throw new \Exception;
            }

            foreach ($Pocket->pocketItems as $Item) {
                $item_ids[] = $this->addItem($quest_id, $Item);
            }
        }

        return $item_ids;
    }

    /**
     * @param $quest_id
     * @param QuestPocketItem $Item
     * @return int
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    private function addItem($quest_id, $Item)
    {
        $QuestItem = GameQuestPocketItem::find()
            ->andWhere('id = :id', [':id' => $Item->id])
            ->one();
        if(!$QuestItem) {
            $QuestItem = new GameQuestPocketItem();
            $QuestItem->id = $Item->id;
            $QuestItem->pocket_id = $Item->pocket_id;
            $QuestItem->global_parent_id = $quest_id;
        }

        $QuestItem->pocket_item_id = $Item->pocket_item_id; //ID части в игре
        $QuestItem->pocket_item_type = $Item->pocket_item_type;
        $QuestItem->item_type = $Item->item_type;
        $QuestItem->count = $Item->count;
        if(!$QuestItem->save()) {
            throw new \Exception;
        }

        //Добавляем информацию о предмете
        $rows = [];
        foreach ($Item->info->getAttributes() as $field => $value) {
            if($value == '') {
                continue;
            }
            $rows[] = [
                'item_id'           => $Item->id,
                'field'             => $field,
                'value'             => $value,
                'global_parent_id'  => $quest_id,
                'pocket_id'         => $Item->pocket_id,
                'pocket_item_id'    => $Item->pocket_item_id,
                'pocket_item_type'  => $Item->pocket_item_type
            ];
        }

        GameUserQuestPartItem::updateAll(['need_count' => $Item->count], 'item_id = :item_id', [':item_id' => $Item->id]);

        if($rows) {
            GameQuestPocketItemInfo::getDb()->createCommand()
                ->batchInsert(GameQuestPocketItemInfo::tableName(), (new GameQuestPocketItemInfo)->attributes(), $rows)->execute();
        }

        try {
            if($Item->info->hasValidatorList()) {
                switch ($Item->pocket_item_type) {
                    case QuestPocket::TYPE_PART_TASK:
                        $this->validatorItemTask($quest_id, $Item);
                        break;
                    case QuestPocket::TYPE_PART_REWARD:
                        $this->validatorItemReward($quest_id, $Item);
                        break;
                }
            }

        } catch (\Exception $ex) {

        }

        return $QuestItem->id;
    }

    /**
     * @param QuestPocketItem $Item
     * @param integer $quest_id
     * @throws \Exception
     */
    private function validatorItemTask($quest_id, $Item)
    {
		GameQuestValidatorItem::deleteAll('parent_id = :id and parent_type = :type', [
			':id' => $Item->id,
			':type' => QuestValidatorItem::PARENT_TYPE_VALIDATOR_TASK,
		]);
		GameQuestValidatorItemInfo::deleteAll('validator_parent_id = :id and validator_parent_type = :type', [
			':id' => $Item->id,
			':type' => QuestValidatorItem::PARENT_TYPE_VALIDATOR_TASK,
		]);

        foreach ($Item->info->getValidatorList() as $Validator) {
            $GameQuestValidatorItem = new GameQuestValidatorItem();
            $GameQuestValidatorItem->id = $Validator->id;
            $GameQuestValidatorItem->item_type = $Validator->item_type;
            $GameQuestValidatorItem->parent_id = $Validator->parent_id;
            $GameQuestValidatorItem->parent_type = $Validator->parent_type;
            $GameQuestValidatorItem->global_parent_id = $quest_id;
            if(!$GameQuestValidatorItem->save()) {
                throw new \Exception;
            }

            $rows = [];
            foreach ($Validator->info->getAttributes() as $field => $value) {
				if($value == '') {
					continue;
				}
                $rows[] = [
                    'item_id'                   => $Validator->id,
                    'field'                     => $field,
                    'value'                     => $value,
                    'validator_item_type'       => $Validator->item_type,
                    'validator_parent_id'       => $Validator->parent_id,
                    'validator_parent_type'     => $Validator->parent_type,
                    'global_parent_id'     		=> $quest_id,
                ];
            }

            if($rows) {
                GameQuestValidatorItemInfo::getDb()->createCommand()
                    ->batchInsert(GameQuestValidatorItemInfo::tableName(), (new GameQuestValidatorItemInfo)->attributes(), $rows)->execute();
            }
        }
    }

    private function validatorItemReward($quest_id, $Item)
    {
        GameQuestValidatorItem::deleteAll('parent_id = :id and parent_type = :type', [
            ':id' => $Item->id,
            ':type' => QuestValidatorItem::PARENT_TYPE_VALIDATOR_REWARD,
        ]);
        GameQuestValidatorItemInfo::deleteAll('validator_parent_id = :id and validator_parent_type = :type', [
            ':id' => $Item->id,
            ':type' => QuestValidatorItem::PARENT_TYPE_VALIDATOR_REWARD,
        ]);
        foreach ($Item->info->getValidatorList() as $Validator) {
            $GameQuestValidatorItem = new GameQuestValidatorItem();
            $GameQuestValidatorItem->id = $Validator->id;
            $GameQuestValidatorItem->item_type = $Validator->item_type;
            $GameQuestValidatorItem->parent_id = $Validator->parent_id;
            $GameQuestValidatorItem->parent_type = $Validator->parent_type;
            $GameQuestValidatorItem->global_parent_id = $quest_id;
            if(!$GameQuestValidatorItem->save()) {
                throw new \Exception;
            }

            $rows = [];
            foreach ($Validator->info->getAttributes() as $field => $value) {
				if($value == '') {
					continue;
				}
                $rows[] = [
                    'item_id'                   => $Validator->id,
                    'field'                     => $field,
                    'value'                     => $value,
                    'validator_item_type'       => $Validator->item_type,
                    'validator_parent_id'       => $Validator->parent_id,
                    'validator_parent_type'     => $Validator->parent_type,
					'global_parent_id'			=> $quest_id,
                ];
            }

            if($rows) {
                GameQuestValidatorItemInfo::getDb()->createCommand()
                    ->batchInsert(GameQuestValidatorItemInfo::tableName(), (new GameQuestValidatorItemInfo)->attributes(), $rows)->execute();
            }
        }
    }

    /**
     * Finds the QuestList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
