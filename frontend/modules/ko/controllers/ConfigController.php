<?php

namespace frontend\modules\ko\controllers;

use common\models\Notepad;
use common\models\oldbk\ConfigKoMain;
use common\models\oldbk\search\ConfigKoMainSearch;
use frontend\components\AuthController;
use GuzzleHttp\Client;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class ConfigController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        return $parent;
    }

    public function actionIndex()
    {
		$searchModel = new ConfigKoMainSearch(['scenario' => ConfigKoMainSearch::SCENARIO_SEARCH]);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


		$Notepad = Notepad::find()
			->andWhere('place = :place', [':place' => Notepad::PLACE_CONFIG_KO])
			->one();

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'notepad' => $Notepad,
		]);
    }

	/**
	 * Creates a new QuestList model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new ConfigKoMain();

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
	 * Displays a single QuestList model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionCache()
	{
		$key = 'Nbg1kRvwb81Q';

		$client = new Client();
		$res = $client->request('GET', 'http://chat.oldbk.com/cache.php?key='.$key);
		$chat = Json::decode($res->getBody()->getContents());


		$client = new Client();
		$res = $client->request('GET', 'https://oldbk.com/f/cache/ko?key='.$key);
		$front = Json::decode($res->getBody()->getContents());

		$client = new Client();
		$res = $client->request('GET', 'http://capitalcity.oldbk.com/action/api/configKoCache?key=XTVoEUoiDpAeGNQz6rFHGM5vbH');
		$cap = Json::decode($res->getBody()->getContents());

		if(isset($chat['status']) && $chat['status'] == 1 && isset($front['status']) && $front['status'] == 1 && isset($cap['status']) && $cap['status'] == 1) {
			return Json::encode([
				'success' => true,
				'messages' => [
					[
						'title' => 'Операция завершена успешно',
						'text' => 'Кэш КО очищен',
					]
				]
			]);
		}

		return Json::encode([
			'error' => true,
			'messages' => [
				[
					'title' => 'Операция завершена с ошибкой',
					'text' => 'Не удалось очистить кэш КО',
				]
			]
		]);
	}

	/**
	 * Finds the QuestList model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ConfigKoMain the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ConfigKoMain::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
