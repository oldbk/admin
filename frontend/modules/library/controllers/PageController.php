<?php

namespace frontend\modules\library\controllers;

use frontend\components\AuthController;
use Yii;
use common\models\oldbk\LibraryPage;
use common\models\oldbk\search\LibraryPageSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use GuzzleHttp\Client;
use yii\helpers\Json;

/**
 * PageController implements the CRUD actions for LibraryPage model.
 */
class PageController extends AuthController
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
     * Lists all LibraryPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibraryPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy('order_position asc');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LibraryPage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LibraryPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LibraryPage();

        if ($model->load(Yii::$app->request->post())) {
            $LastDialog = LibraryPage::find()
				->andWhere('category_id = :category_id', [':category_id' => $model->category_id])
                ->orderBy('order_position desc')
                ->one();
            $position = 1;
            if($LastDialog) {
                $position = $LastDialog->order_position + 1;
            }
            $model->order_position = $position;
            if($model->save()) {
				return $this->redirect(['index']);
			}
        }

		return $this->render('create', [
			'model' => $model,
		]);
    }

    /**
     * Updates an existing LibraryPage model.
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
        $res = $client->request('GET', 'https://oldbk.com/f/cache/all');
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
     * Deletes an existing LibraryPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUp($id)
    {
        $Page = $this->findModel($id);
        $PrevDialog = LibraryPage::find()
			->andWhere('category_id = :category_id and id != :id', [':category_id' => $Page->category_id, ':id' => $Page->id])
            ->andWhere('order_position <= :position', [
                ':position' => $Page->order_position,
            ])
			->orderBy('order_position desc')
            ->one();
        if($PrevDialog) {
            $t = Yii::$app->db->beginTransaction();
            try {

                $Page->order_position = $PrevDialog->order_position;
                if(!$Page->save(false)) {
                    throw new \Exception;
                }

                $PrevDialog->order_position =  $PrevDialog->order_position == $Page->order_position? $Page->order_position + 1 : $Page->order_position;
                if(!$PrevDialog->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(['/library/page/index']);
    }

    public function actionDown($id)
    {
        $Page = $this->findModel($id);
        $NextDialog = LibraryPage::find()
			->andWhere('category_id = :category_id and id != :id', [':category_id' => $Page->category_id, ':id' => $Page->id])
            ->andWhere('order_position >= :position', [
                ':position' => $Page->order_position,
            ])
			->orderBy('order_position asc')
            ->one();
        if($NextDialog) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Page->order_position = $NextDialog->order_position;
                if(!$Page->save(false)) {
                    throw new \Exception;
                }

                $NextDialog->order_position = $NextDialog->order_position == $Page->order_position ? $Page->order_position - 1 : $Page->order_position;
                if(!$NextDialog->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(['/library/page/index']);
    }

    /**
     * Finds the LibraryPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LibraryPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LibraryPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
