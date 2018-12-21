<?php

namespace frontend\modules\rate\controllers;

use common\models\oldbk\EventRating;
use common\models\oldbk\EventRatingCondition;
use common\models\rateCondition\BaseCondition;
use common\models\RateManager;
use common\models\RateManagerCondition;
use common\models\search\RateManagerSearch;
use frontend\components\AuthController;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class ManagerController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        return $parent;
    }

    public function actionIndex()
    {
        $searchModel = new RateManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
	{
		$model = new RateManager();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * @param $id
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionView($id)
	{
		$Rate = RateManager::find()
			->andWhere(['=', 'id', $id])
			->one();


		$Conditions = RateManagerCondition::find()
			->where('rate_id = :rate_id', [':rate_id' => $id])
			->all();

		$types = [];
		foreach ($Conditions as $Condition) {
			$types[$Condition->group][$Condition->condition_type][$Condition->field] = $Condition->value;
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
					'group' => $group,
					'rate_id' => $id,
				];
				$i++;
			}
		}

		$ConditionProvider = new ArrayDataProvider([
			'allModels' => $List,
			'pagination' => [
				'pageSize' => 10,
			],
			'sort' => [
				'attributes' => ['id', 'name'],
			],
		]);

		return $this->render('view', [
			'model' => $Rate,
			'conditionProvider' => $ConditionProvider,
		]);
	}

	/**
	 * @param $id
	 * @return string
	 * @throws \yii\db\Exception
	 */
	public function actionExport($id)
	{
		$t = EventRating::getDb()->beginTransaction();
		try {
			$Rating = RateManager::find()
				->andWhere(['=', 'id', $id])
				->one();
			if(!$Rating) {
				throw new \Exception();
			}

			$RatingBK = EventRating::find()
				->andWhere(['=', 'id', $id])
				->one();
			if(!$RatingBK) {
				$RatingBK = new EventRating();
			}
			$RatingBK->id = $Rating->id;
			$RatingBK->key = $Rating->rate_key;
			$RatingBK->name = $Rating->name;
			$RatingBK->description = $Rating->description;
			$RatingBK->icon = $Rating->icon;
			$RatingBK->link = $Rating->link;
			$RatingBK->link_encicl = $Rating->link_encicl;
			$RatingBK->is_enabled = $Rating->is_enabled;
			$RatingBK->enable_type = $Rating->iteration;
			$RatingBK->reward_till_days = $Rating->reward_till_days;
			if(!$RatingBK->save()) {
				throw new \Exception();
			}

			EventRatingCondition::deleteAll('rate_id = :rate_id', [':rate_id' => $RatingBK->id]);
			foreach ($Rating->conditions as $Condition) {
				$ConditionBK = new EventRatingCondition();
				$ConditionBK->group = $Condition->group;
				$ConditionBK->rate_id = $Condition->rate_id;
				$ConditionBK->condition_type = $Condition->condition_type;
				$ConditionBK->field = $Condition->field;
				$ConditionBK->value = $Condition->value;
				if(!$ConditionBK->save()) {
					throw new \Exception();
				}
			}

			foreach ($Rating->poolAssigns as $PoolAssign) {
				$PoolAssignBK = \common\models\oldbk\pool\PoolAssign::find()
					->andWhere(['=', 'id', $PoolAssign->id])
					->one();
				if(!$PoolAssignBK) {
					$PoolAssignBK 				= new \common\models\oldbk\pool\PoolAssign();
					$PoolAssignBK->id 			= $PoolAssign->id;
				}
				$PoolAssignBK->pool_id 		= $PoolAssign->pool_id;
				$PoolAssignBK->target_type 	= $PoolAssign->target_type;
				$PoolAssignBK->target_id 	= $PoolAssign->target_id;
				$PoolAssignBK->target_name 	= $PoolAssign->target_name;
				if(!$PoolAssignBK->save()) {
					throw new \Exception();
				}

				if($PoolAssign->assignRating) {
					$SettingsBK = \common\models\oldbk\pool\PoolAssignRating::find()
						->andWhere(['=', 'pool_assign_id', $PoolAssign->id])
						->one();
					if(!$SettingsBK) {
						$SettingsBK = new \common\models\oldbk\pool\PoolAssignRating();
						$SettingsBK->pool_assign_id = $PoolAssign->assignRating->pool_assign_id;
					}
					$SettingsBK->rating_id = $PoolAssign->assignRating->rating_id;
					$SettingsBK->min_position = $PoolAssign->assignRating->min_position;
					$SettingsBK->max_position = $PoolAssign->assignRating->max_position;
					if(!$SettingsBK->save()) {
						throw new \Exception();
					}
				}

				\common\models\oldbk\pool\PoolValidatorInfo::deleteAll('pool_id = :pool_id', [':pool_id' => $PoolAssign->pool_id]);
				\common\models\oldbk\pool\PoolValidator::deleteAll('pool_id = :pool_id', [':pool_id' => $PoolAssign->pool_id]);
				\common\models\oldbk\pool\PoolPocketItemInfo::deleteAll('pool_id = :pool_id', [':pool_id' => $PoolAssign->pool_id]);
				\common\models\oldbk\pool\PoolPocketItem::deleteAll('pool_id = :pool_id', [':pool_id' => $PoolAssign->pool_id]);
				\common\models\oldbk\pool\PoolPocket::deleteAll('pool_id = :pool_id', [':pool_id' => $PoolAssign->pool_id]);
				\common\models\oldbk\pool\Pool::deleteAll('id = :id', [':id' => $PoolAssign->pool_id]);

				$PoolBK = new \common\models\oldbk\pool\Pool();
				$PoolBK->id = $PoolAssign->pool->id;
				$PoolBK->name = $PoolAssign->pool->name;
				if(!$PoolBK->save()) {
					throw new \Exception();
				}

				foreach ($PoolAssign->pool->pockets as $Pocket) {
					$PocketBK = new \common\models\oldbk\pool\PoolPocket();
					$PocketBK->id = $Pocket->id;
					$PocketBK->pool_id = $Pocket->pool_id;
					$PocketBK->description = $Pocket->description;
					$PocketBK->condition = $Pocket->condition;
					if(!$PocketBK->save()) {
						throw new \Exception();
					}

					foreach ($Pocket->items as $Item) {
						$ItemBK = new \common\models\oldbk\pool\PoolPocketItem();
						$ItemBK->id = $Item->id;
						$ItemBK->pool_id = $Item->pool_id;
						$ItemBK->pocket_id = $Item->pocket_id;
						$ItemBK->item_type = $Item->item_type;
						$ItemBK->give_count = $Item->give_count;
						if(!$ItemBK->save()) {
							throw new \Exception();
						}

						foreach ($Item->itemInfo as $ItemInfo) {
							$ItemInfoBK = new \common\models\oldbk\pool\PoolPocketItemInfo();
							$ItemInfoBK->pocket_item_id = $ItemInfo->pocket_item_id;
							$ItemInfoBK->field = $ItemInfo->field;
							$ItemInfoBK->value = $ItemInfo->value;
							$ItemInfoBK->pool_id = $ItemInfo->pool_id;
							$ItemInfoBK->pocket_id = $ItemInfo->pocket_id;
							if(!$ItemInfoBK->save()) {
								throw new \Exception();
							}
						}

						foreach ($Item->itemValidators as $ItemValidator) {
							$ItemValidatorBK = new 	\common\models\oldbk\pool\PoolValidator();
							$ItemValidatorBK->id = $ItemValidator->id;
							$ItemValidatorBK->target_type = $ItemValidator->target_type;
							$ItemValidatorBK->target_id = $ItemValidator->target_id;
							$ItemValidatorBK->validator_type = $ItemValidator->validator_type;
							$ItemValidatorBK->pool_id = $ItemValidator->pool_id;
							$ItemValidatorBK->pocket_id = $ItemValidator->pocket_id;
							if(!$ItemValidatorBK->save()) {
								throw new \Exception();
							}

							foreach ($ItemValidator->validatorInfo as $ValidatorInfo) {
								$ValidatorInfoBK = new \common\models\oldbk\pool\PoolValidatorInfo();
								$ValidatorInfoBK->validator_id = $ValidatorInfo->validator_id;
								$ValidatorInfoBK->field = $ValidatorInfo->field;
								$ValidatorInfoBK->value = $ValidatorInfo->value;
								$ValidatorInfoBK->target_type = $ValidatorInfo->target_type;
								$ValidatorInfoBK->target_id = $ValidatorInfo->target_id;
								$ValidatorInfoBK->pool_id = $ValidatorInfo->pool_id;
								$ValidatorInfoBK->pocket_id = $ValidatorInfo->pocket_id;
								if(!$ValidatorInfoBK->save()) {
									throw new \Exception();
								}
							}
						}
					}
				}
			}

			$t->commit();

			return Json::encode([
				'success' => true,
				'messages' => [
					[
						'title' => 'Операция завершена. Экспорт рейтинга',
						'text' => 'Успешно экспортировали рейтинг'
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
						'line' => $ex->getLine(),
						'debug' => $ex->getTraceAsString(),
					]
				]
			]);
		}
	}

    /**
     * Finds the QuestPart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RateManager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RateManager::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
