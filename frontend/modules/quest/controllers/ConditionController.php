<?php

namespace frontend\modules\quest\controllers;

use common\helper\ShopHelper;
use common\models\itemInfo\ItemInfo;
use common\models\oldbk\CraftProf;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Ivents;
use common\models\oldbk\Shop;
use common\models\Quest;
use common\models\QuestCondition;
use common\models\questCondition\QuestConditionAlign;
use common\models\questCondition\QuestConditionCount;
use common\models\questCondition\QuestConditionDate;
use common\models\questCondition\QuestConditionGender;
use common\models\questCondition\QuestConditionItem;
use common\models\questCondition\QuestConditionLevel;
use common\models\questCondition\QuestConditionMedal;
use common\models\questCondition\QuestConditionProf;
use common\models\questCondition\QuestConditionQuest;
use common\models\questCondition\QuestConditionWeek;
use common\models\QuestMedal;
use common\models\questPocket\QuestPocketPartTake;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use frontend\components\AuthController;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class ConditionController extends AuthController
{
    private function getReturnLink($item_id, $item_type)
    {
        switch ($item_type) {
            case QuestCondition::ITEM_TYPE_QUEST:
                return Url::to(['/quest/quest/view', 'id' => $item_id]);
                break;
            case QuestCondition::ITEM_TYPE_PART:
                return Url::to(['/quest/part/view', 'id' => $item_id]);
                break;
        }

        return null;
    }

    public function actionQuest($item_id, $item_type)
    {
        $model = new QuestConditionQuest();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;

                $Quest = Quest::findOne($model->quest_id);
                $model->quest_name = $Quest->name;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('quest', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }

    public function actionItem($item_id, $item_type)
    {
        $model = new QuestConditionItem();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('item', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }

    public function actionMedal($item_id, $item_type)
    {
        $model = new QuestConditionMedal();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;

                $Medal = QuestMedal::findOne($model->medal_key);
                $model->medal_name = $Medal->name;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('medal', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }


	public function actionWeek($item_id, $item_type)
	{
		$model = new QuestConditionWeek();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				$Last = QuestCondition::find()
					->orderBy('group desc')
					->one();
				$group = $Last->group + 1;

				$Week = Ivents::findOne($model->week_id);
				$model->week_name = $Week->nazv;

				$rows = [];
				foreach ($model->getAttributes() as $field => $value) {
					if(!$value) {
						continue;
					}
					$rows[] = [
						'group'          => $group,
						'item_id'        => $item_id,
						'item_type'      => $item_type,
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

			return $this->redirect($this->getReturnLink($item_id, $item_type));
		}

		return $this->render('week', [
			'model' => $model,
			'return_url' => $this->getReturnLink($item_id, $item_type),
		]);
	}

    public function actionLevel($item_id, $item_type)
    {
        $model = new QuestConditionLevel();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('level', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }

    public function actionAlign($item_id, $item_type)
    {
        $model = new QuestConditionAlign();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value && $value != 0) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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
                var_dump($ex->getMessage());
                $t->rollBack();
            }

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('align', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }

    public function actionDate($item_id, $item_type)
    {
        $model = new QuestConditionDate();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;
                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('date', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }

    public function actionProf($item_id, $item_type)
    {
        $model = new QuestConditionProf();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Profession = CraftProf::findOne($model->profession_id);
                if(!$Profession) {
                    throw new \Exception('Не нашли профессию');
                }

                $model->profession_name = $Profession->rname;
                $Last = QuestCondition::find()
                    ->orderBy('group desc')
                    ->one();
                $group = $Last->group + 1;

                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value && $value != 0) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'item_id'        => $item_id,
                        'item_type'      => $item_type,
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
                var_dump($ex->getMessage());
                $t->rollBack();
            }

            return $this->redirect($this->getReturnLink($item_id, $item_type));
        }

        return $this->render('prof', [
            'model' => $model,
            'return_url' => $this->getReturnLink($item_id, $item_type),
        ]);
    }

	public function actionCount($item_id, $item_type)
	{
		$model = new QuestConditionCount();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				$Last = QuestCondition::find()
					->orderBy('group desc')
					->one();
				$group = $Last->group + 1;
				$rows = [];
				foreach ($model->getAttributes() as $field => $value) {
					if(!$value) {
						continue;
					}
					$rows[] = [
						'group'          => $group,
						'item_id'        => $item_id,
						'item_type'      => $item_type,
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

			return $this->redirect($this->getReturnLink($item_id, $item_type));
		}

		return $this->render('count', [
			'model' => $model,
			'return_url' => $this->getReturnLink($item_id, $item_type),
		]);
	}

	public function actionGender($item_id, $item_type)
	{
		$model = new QuestConditionGender();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				$Last = QuestCondition::find()
					->orderBy('group desc')
					->one();
				$group = $Last->group + 1;
				$rows = [];
				foreach ($model->getAttributes() as $field => $value) {
					$rows[] = [
						'group'          => $group,
						'item_id'        => $item_id,
						'item_type'      => $item_type,
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

			return $this->redirect($this->getReturnLink($item_id, $item_type));
		}

		return $this->render('gender', [
			'model' => $model,
			'return_url' => $this->getReturnLink($item_id, $item_type),
		]);
	}

    public function actionDelete($group_id, $item_id, $item_type)
    {
        QuestCondition::deleteAll([
            'group'     => $group_id,
            'item_id'   => $item_id,
            'item_type' => $item_type,
        ]);

        return $this->redirect($this->getReturnLink($item_id, $item_type));
    }
}
