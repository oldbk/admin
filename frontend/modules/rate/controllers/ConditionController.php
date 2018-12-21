<?php

namespace frontend\modules\rate\controllers;

use common\models\oldbk\Ivents;
use common\models\rateCondition\RateConditionDateRang;
use common\models\RateManagerCondition;
use common\models\rateCondition\RateConditionDate;
use common\models\rateCondition\RateConditionWeek;
use frontend\components\AuthController;
use Yii;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class ConditionController extends AuthController
{
	public function actionWeek($rate_id)
	{
		$model = new RateConditionWeek();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				$Last = RateManagerCondition::find()
					->orderBy('group desc')
					->one();
				$group = 1;
				if($Last) {
					$group = $Last->group + 1;
				}

				$Week = Ivents::findOne($model->week_id);
				$model->week_name = $Week->nazv;

				$rows = [];
				foreach ($model->getAttributes() as $field => $value) {
					if(!$value) {
						continue;
					}
					$rows[] = [
						'group'          => $group,
						'rate_id'     	 => $rate_id,
						'condition_type' => $model->getConditionType(),
						'field'          => $field,
						'value'          => $value,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(RateManagerCondition::tableName(), (new RateManagerCondition)->attributes(), $rows)->execute();
				}

				$t->commit();
			} catch (\Exception $ex) {
				$t->rollBack();
			}

			return $this->redirect(['/rate/manager/view', 'id' => $rate_id]);
		}

		return $this->render('week', [
			'model' 	=> $model,
			'rate_id' => $rate_id,
		]);
	}

    public function actionDate($rate_id)
    {
        $model = new RateConditionDate();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Last = RateManagerCondition::find()
                    ->orderBy('group desc')
                    ->one();
				$group = 1;
                if($Last) {
					$group = $Last->group + 1;
				}
                $rows = [];
                foreach ($model->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'group'          => $group,
                        'rate_id'      	 => $rate_id,
                        'condition_type' => $model->getConditionType(),
                        'field'          => $field,
                        'value'          => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(RateManagerCondition::tableName(), (new RateManagerCondition)->attributes(), $rows)->execute();
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
                var_dump($ex->getMessage());
            }

            return $this->redirect(['/rate/manager/view', 'id' => $rate_id]);
        }

        return $this->render('date', [
            'model' 	=> $model,
            'rate_id' 	=> $rate_id,
        ]);
    }

	public function actionDateRange($rate_id)
	{
		$model = new RateConditionDateRang();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				$Last = RateManagerCondition::find()
					->orderBy('group desc')
					->one();
				$group = 1;
				if($Last) {
					$group = $Last->group + 1;
				}
				$rows = [];

				foreach ($model->getAttributes() as $field => $value) {
					if(!$value) {
						continue;
					}
					$rows[] = [
						'group'          => $group,
						'rate_id'      	 => $rate_id,
						'condition_type' => $model->getConditionType(),
						'field'          => $field,
						'value'          => $value,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(RateManagerCondition::tableName(), (new RateManagerCondition)->attributes(), $rows)->execute();
				}

				$t->commit();
			} catch (\Exception $ex) {
				$t->rollBack();
			}

			return $this->redirect(['/rate/manager/view', 'id' => $rate_id]);
		}

		return $this->render('date_rang', [
			'model' => $model,
			'rate_id' 	=> $rate_id,
		]);
	}

    public function actionDelete($group_id, $rate_id)
    {
		RateManagerCondition::deleteAll([
            'group' 	=> $group_id,
            'rate_id' 	=> $rate_id,
        ]);

		return $this->redirect(['/rate/manager/view', 'id' => $rate_id]);
    }
}
