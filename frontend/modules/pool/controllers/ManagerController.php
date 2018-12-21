<?php

namespace frontend\modules\pool\controllers;

use common\models\pool\Pool;
use common\models\pool\PoolItem;
use common\models\pool\PoolItemDetails;
use common\models\pool\PoolPocket;
use common\models\pool\PoolPocketItem;
use common\models\pool\PoolPocketItemInfo;
use common\models\pool\PoolValidator;
use common\models\pool\PoolValidatorInfo;
use common\models\search\pool\PoolItemSearch;
use common\models\search\pool\PoolSearch;
use Yii;
use frontend\components\AuthController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Class ManagerController
 * @package frontend\modules\pool\controllers
 */
class ManagerController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	/**
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new PoolSearch(['scenario' => Pool::SCENARIO_SEARCH]);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->with('ratings');
		$dataProvider->pagination->pageSize = 20;

		return $this->render('index', [
			'searchModel' 	=> $searchModel,
			'dataProvider' 	=> $dataProvider,
		]);
	}

	/**
	 * @param $id
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		$Pool = $this->findModel($id);

		return $this->render('view', [
			'model' => $Pool,
		]);
	}

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Pool();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['/pool/manager/index']);
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
			return $this->redirect(['/pool/manager/index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * @param $id
	 * @return \yii\web\Response
	 * @throws \yii\db\Exception
	 */
	public function actionClone($id)
	{
		$t = Yii::$app->db->beginTransaction();
		try {
			/** @var Pool $Pool */
			$Pool = Pool::find()
				->andWhere('id = :id', [':id' => $id])
				->with([
					'pockets',
					'pockets.items',
					'pockets.items.itemInfo',
					'pockets.items.itemValidators',
					'pockets.items.itemValidators.validatorInfo',
				])
				->one();

			$PoolCopy 		= new Pool();
			$PoolCopy->name = 'Копия '.$Pool->name;
			if(!$PoolCopy->save()) {
				throw new \Exception('Can\'t save pool');
			}

			foreach ($Pool->pockets as $Pocket) {
				$PocketCopy 				= new PoolPocket();
				$PocketCopy->pool_id 		= $PoolCopy->id;
				$PocketCopy->description 	= $Pocket->description;
				$PocketCopy->condition 		= $Pocket->condition;
				if(!$PocketCopy->save()) {
					throw new \Exception('Can\'t save pocket');
				}

				foreach ($Pocket->items as $Item) {
					$ItemCopy 				= new PoolPocketItem();
					$ItemCopy->pool_id 		= $PocketCopy->pool_id;
					$ItemCopy->pocket_id 	= $PocketCopy->id;
					$ItemCopy->item_type 	= $Item->item_type;
					$ItemCopy->give_count 	= $Item->give_count;
					if(!$ItemCopy->save()) {
						throw new \Exception('Can\'t save item');
					}

					foreach ($Item->itemInfo as $ItemInfo) {
						$ItemInfoCopy 					= new PoolPocketItemInfo();
						$ItemInfoCopy->pocket_item_id 	= $ItemCopy->id;
						$ItemInfoCopy->pool_id 			= $ItemCopy->pool_id;
						$ItemInfoCopy->pocket_id 		= $ItemCopy->pocket_id;
						$ItemInfoCopy->field 			= $ItemInfo->field;
						$ItemInfoCopy->value 			= $ItemInfo->value;
						if(!$ItemInfoCopy->save()) {
							throw new \Exception('Can\'t save info');
						}
					}

					foreach ($Item->itemValidators as $Validator) {
						$ValidatorCopy 					= new PoolValidator();
						$ValidatorCopy->target_id 		= $ItemCopy->id;
						$ValidatorCopy->pool_id 		= $ItemCopy->pool_id;
						$ValidatorCopy->pocket_id 		= $ItemCopy->pocket_id;
						$ValidatorCopy->target_type 	= $Validator->target_type;
						$ValidatorCopy->validator_type 	= $Validator->validator_type;
						if(!$ValidatorCopy->save()) {
							throw new \Exception('Can\'t save validator');
						}

						foreach ($Validator->validatorInfo as $ValidatorInfo) {
							$ValidatorInfoCopy 					= new PoolValidatorInfo();
							$ValidatorInfoCopy->validator_id 	= $ValidatorCopy->id;
							$ValidatorInfoCopy->target_type 	= $ValidatorCopy->target_type;
							$ValidatorInfoCopy->target_id 		= $ValidatorCopy->target_id;
							$ValidatorInfoCopy->pool_id 		= $ValidatorCopy->pool_id;
							$ValidatorInfoCopy->pocket_id 		= $ValidatorCopy->pocket_id;
							$ValidatorInfoCopy->field 			= $ValidatorInfo->field;
							$ValidatorInfoCopy->value 			= $ValidatorInfo->value;
							if(!$ValidatorInfoCopy->save()) {
								throw new \Exception('Can\'t save validator info');
							}
						}
					}
				}
			}

			$t->commit();
		} catch (\Exception $ex) {
			$t->rollBack();
			var_dump($ex->getMessage());die;
		}

		return $this->redirect(['index']);
	}

	/**
	 * @param $id
	 * @return Pool|null
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = Pool::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
