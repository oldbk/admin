<?php

namespace frontend\modules\pool\controllers;

use common\models\pool\PoolPocket;
use common\models\pool\PoolPocketItem;
use common\models\pool\PoolPocketItemInfo;
use common\models\pool\PoolValidator;
use common\models\pool\PoolValidatorInfo;
use Yii;
use frontend\components\AuthController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Class ManagerController
 * @package frontend\modules\pool\controllers
 */
class PocketController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	/**
	 * @param $pool_id
	 * @return string|\yii\web\Response
	 */
	public function actionCreate($pool_id)
	{
		$model = new PoolPocket();
		$model->pool_id = $pool_id;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['/pool/manager/view', 'id' => $pool_id]);
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
			return $this->redirect(['/pool/manager/view', 'id' => $model->pool_id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * @param $id
	 * @return bool|\yii\web\Response
	 * @throws \Throwable
	 * @throws \yii\db\Exception
	 */
	public function actionDelete($id)
	{
		$t = Yii::$app->db->beginTransaction();
		$model = PoolPocket::find()
			->andWhere('id = :id', [':id' => $id])
			->one();

		if(!$model) {
			return false;
		}
		$pool_id = $model->pool_id;

		try {
			PoolPocketItemInfo::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);
			PoolPocketItem::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);
			PoolValidatorInfo::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);
			PoolValidator::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $model->id]);

			$model->delete();

			$t->commit();
		} catch (\Exception $ex) {
			$t->rollBack();
		}

		return $this->redirect(['/pool/manager/view', 'id' => $pool_id]);
	}

	/**
	 * @param $id
	 * @return PoolPocket|null
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = PoolPocket::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
