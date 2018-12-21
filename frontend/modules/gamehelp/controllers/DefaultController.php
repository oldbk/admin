<?php

namespace frontend\modules\gamehelp\controllers;

use frontend\components\AuthController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\oldbk\Gamehelp;
use common\models\oldbk\search\GamehelpSearch;
use GuzzleHttp\Client;
use yii\helpers\Json;

/**
 * DefaultController implements the CRUD actions for LibraryCategory model.
 */
class DefaultController extends AuthController
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
        $searchModel = new GamehelpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 50;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new LibraryCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gamehelp;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		return $this->redirect(['index']);
        } else {
		return $this->render('create', [
			'model' => $model,
		]);
        }
    }

    /**
     * Updates an existing LibraryCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionCache()
    {
        $client = new Client();
        $res = $client->request('GET', 'http://capitalcity.oldbk.com/action/api/gamehelpCache');
        $data = Json::decode($res->getBody()->getContents());

        if($data['ok'] == true) {
            return Json::encode([
                'success' => true,
                'messages' => [
                    ['title' => 'Операция завершена', 'text' => 'Кэш успешно очистился']
                ],
            ]);
        } else {
            return Json::encode([
                'error' => true,
                'messages' => [
                    ['title' => 'Операция завершена', 'text' => 'Во время выполнения кэш не очистился']
                ],
            ]);
        }
    }

    /**
     * Deletes an existing LibraryCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Gamehelp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
