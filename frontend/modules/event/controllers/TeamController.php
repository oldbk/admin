<?php

namespace frontend\modules\event\controllers;

use common\models\event\EventWc;
use common\models\event\EventWcTeam;
use common\models\search\event\EventWcSearch;
use common\models\search\event\EventWcTeamSearch;
use frontend\components\AuthController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * DefaultController implements the CRUD actions for LibraryCategory model.
 */
class TeamController extends AuthController
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
		$searchModel = new EventWcTeamSearch(['scenario' => EventWcTeam::SCENARIO_SEARCH]);

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 20;

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
		$model = new EventWcTeam();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['/event/team/index']);
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
			return $this->redirect(['/event/team/index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * @param $id
	 * @return EventWcTeam|null
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = EventWcTeam::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
