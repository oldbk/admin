<?php

namespace frontend\modules\event\controllers;

use common\models\event\EventWc;
use common\models\oldbk\WcEvent;
use common\models\oldbk\WcEventBet;
use common\models\search\event\EventWcSearch;
use frontend\components\AuthController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * DefaultController implements the CRUD actions for LibraryCategory model.
 */
class Wc18Controller extends AuthController
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
     * Lists all LibraryCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel 		= new EventWcSearch(['scenario' => EventWc::SCENARIO_SEARCH]);
		$searchModel->year 	= 2018;

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 200;

		return $this->render('index', [
			'searchModel' 	=> $searchModel,
			'dataProvider' 	=> $dataProvider,
		]);
    }

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new EventWc();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['/event/wc18/index']);
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
			return $this->redirect(['/event/wc18/index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionExport()
	{
		$Events = EventWc::find()
			->with(['team1', 'team2'])
			->all();

		$t = WcEvent::getDb()->beginTransaction();
		try {
			foreach ($Events as $Event) {
				$OldBKWcEvent = WcEvent::findOne($Event->id);
				if(!$OldBKWcEvent) {
					$OldBKWcEvent = new WcEvent();
					$OldBKWcEvent->id 		= $Event->id;
					$OldBKWcEvent->year 	= $Event->year;
					$OldBKWcEvent->team1 	= $Event->team1->name;
					$OldBKWcEvent->team2 	= $Event->team2->name;
					$OldBKWcEvent->datetime = $Event->datetime;
					if(!$OldBKWcEvent->save()) {
						throw new \Exception();
					}
				}
			}

			$t->commit();
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

		return Json::encode([
			'success' => true,
			'messages' => [
				[
					'title' => 'Операция завершена. Экспорт матчей',
					'text' => 'Успешно экспортировали матчи'
				],
			],
		]);
	}

	public function actionResult($id)
	{
		$model = $this->findModel($id);
		$model->scenario = EventWc::SCENARIO_RESULT;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$t = WcEvent::getDb()->beginTransaction();
			try {
				$Event = WcEvent::findOne($model->id);
				$Event->team1_res = $model->team1_res;
				$Event->team2_res = $model->team2_res;
				$Event->who_win = $model->who_win;
				if(!$Event->save()) {
					throw new \Exception();
				}

				WcEventBet::updateAll(['is_win' => 1], 'wc_event_id = :event_id and res = :res', [
					':event_id' => $model->id,
					':res' => $model->who_win
				]);

				if(!$model->save()) {
					throw new \Exception();
				}

				$t->commit();

				return Json::encode(['status' => 1]);
			} catch (\Exception $ex) {
				$t->rollBack();

				return Json::encode([
					'status' => 0,
					'html' => $this->renderPartial('wc_change', ['model' => $model])
				]);
			}
		}

		return $this->renderAjax('wc_change', ['model' => $model]);
	}

	/**
	 * @param $id
	 * @return EventWc|null
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = EventWc::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
