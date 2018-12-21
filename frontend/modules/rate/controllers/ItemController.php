<?php

namespace frontend\modules\rate\controllers;

use common\models\oldbk\search\TopListSearch;
use common\models\oldbk\TopList;
use common\models\QuestPocketItem;
use common\models\search\StatOnlineSearch;
use common\models\StatOnline;
use frontend\components\AuthController;
use GuzzleHttp\Client;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class ItemController extends AuthController
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
        $searchModel = new TopListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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
        $res = $client->request('GET', 'http://top.oldbk.com/rate/tools/cache');
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
     * Finds the QuestPart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestPocketItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TopList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
