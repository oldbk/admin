<?php

namespace frontend\modules\news\controllers;

use common\models\LogNews;
use common\models\Notepad;
use frontend\components\AuthController;
use GuzzleHttp\Client;
use Yii;
use common\models\oldbk\News;
use common\models\oldbk\search\NewsSearch;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends AuthController
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

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $Notepad = Notepad::find()
            ->andWhere('place = :place', [':place' => Notepad::PLACE_NEWS])
            ->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notepad' => $Notepad
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->save()) {
                    throw new \Exception();
                }

                $LogNews = new LogNews();
                $LogNews->news_id = $model->id;
                $LogNews->user_id = Yii::$app->user->id;
                $LogNews->operation = LogNews::OPERATION_CREATE;
                if(!$LogNews->save()) {
                    throw new \Exception();
                }

                $t->commit();

                return $this->redirect(['index']);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $LogNews = new LogNews();
                $LogNews->news_id = $model->id;
                $LogNews->user_id = Yii::$app->user->id;
                $LogNews->operation = LogNews::OPERATION_UPDATE;
                if(!$LogNews->save()) {
                    throw new \Exception();
                }

                $operation = null;
                if($model->isEnable()) {
                    $operation = LogNews::OPERATION_ENABLE;
                }
                if($model->isDisable()) {
                    $operation = LogNews::OPERATION_DISABLE;
                }
                if($operation) {
                    $LogNews = new LogNews();
                    $LogNews->news_id = $model->id;
                    $LogNews->user_id = Yii::$app->user->id;
                    $LogNews->operation = $operation;
                    if(!$LogNews->save()) {
                        throw new \Exception();
                    }
                }

                if(!$model->save()) {
                    throw new \Exception();
                }

                $t->commit();

                return $this->redirect(['index']);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEmpty()
    {
        return $this->render('empty');
    }

    public function actionPreview()
    {
        $title = Yii::$app->request->post('title');
        $text = Yii::$app->request->post('text');
        $date = Yii::$app->request->post('date');

        $content = $this->renderPartial('preview', [
            'title' => $title,
            'text' => $text,
            'date' => $date,
        ]);

        return Json::encode([
            'success' => true,
            'content' => $content
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);

            $LogNews = new LogNews();
            $LogNews->news_id = $model->id;
            $LogNews->user_id = Yii::$app->user->id;
            $LogNews->operation = LogNews::OPERATION_DELETE;
            if(!$LogNews->save()) {
                throw new \Exception();
            }

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['index']);
    }

    public function actionCache()
	{
		$client = new Client();
		$res = $client->request('GET', 'https://oldbk.com/f/cache/news');
		$data = Json::decode($res->getBody()->getContents());
		if(!isset($data['status']) || $data['status'] == 0) {
			return Json::encode([
				'error' => true,
				'messages' => [
					[
						'title' => 'Операция завершена с ошибкой',
						'text' => 'Не удалось очистить кэш новостей',
					]
				]
			]);
		}

		return Json::encode([
			'success' => true,
			'messages' => [
				[
					'title' => 'Операция завершена успешно',
					'text' => 'Кэш новостей очищен',
				]
			]
		]);
	}

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
