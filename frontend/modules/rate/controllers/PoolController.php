<?php

namespace frontend\modules\rate\controllers;

use common\models\pool\PoolAssign;
use common\models\pool\PoolAssignRating;
use common\models\RateManager;
use common\models\search\pool\PoolAssignSearch;
use frontend\components\AuthController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PoolController extends AuthController
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

    public function actionList($rate_id)
    {
		$searchModel = new PoolAssignSearch();
		$searchModel->target_id = $rate_id;
		$searchModel->target_type = PoolAssign::TARGET_RATE;

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->with(['pool', 'assignRating']);
		$dataProvider->pagination->pageSize = 100;
		$dataProvider->pagination->route = '/rate/pool/list';

		return $this->renderPartial('_list', [
			'dataProvider' => $dataProvider,
		]);
    }

	/**
	 * @param $rate_id
	 * @return string|\yii\web\Response
	 * @throws \yii\db\Exception
	 */
    public function actionAssign($rate_id)
	{
		$RateManager = RateManager::find()
			->where(['=', 'id', $rate_id])
			->one();
		if(!$RateManager) {
			return $this->redirect(['/rate/manager/view', 'id' => $rate_id]);
		}

		$model = new PoolAssign();
		$model->target_id = $rate_id;
		$model->target_type = PoolAssign::TARGET_RATE;
		$model->target_name = $RateManager->name;

		$settings = new PoolAssignRating();
		$settings->rating_id = $rate_id;

		if ($model->load(Yii::$app->request->post()) && $settings->load(Yii::$app->request->post())) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->save()) {
					throw new \Exception();
				}

				$settings->pool_assign_id = $model->id;
				if(!$settings->save()) {
					throw new \Exception();
				}

				$t->commit();
			} catch (\Exception $ex) {
				$t->rollBack();
			}

			return $this->redirect(['/rate/manager/view', 'id' => $rate_id]);
		}

		return $this->render('assign', [
			'model' => $model,
			'settings' => $settings,
		]);
	}


	public function actionDelete($id)
	{
		$PoolAssign = PoolAssign::find()
			->where(['=', 'id', $id])
			->one();
		if(!$PoolAssign) {
			throw new HttpException(404);
		}

		$t = Yii::$app->db->beginTransaction();
		try {
			PoolAssignRating::deleteAll('pool_assign_id = :pool_assign_id', [
				':pool_assign_id' => $PoolAssign->id,
			]);

			$PoolAssign->delete();

			$t->commit();
		} catch (\Exception $ex) {
			$t->rollBack();
		}

		return $this->redirect(['/rate/manager/view', 'id' => $PoolAssign->target_id]);
	}
}
