<?php

namespace frontend\modules\item\controllers;

use common\helper\ShopHelper;
use common\models\AbilityOwn;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Shop;
use common\models\search\AbilityOwnSearch;
use frontend\components\AuthController;
use Yii;
use common\models\oldbk\News;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class AbilityController extends AuthController
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
        $searchModel = new AbilityOwnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                return $this->redirect(['index']);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSearch()
    {
        $result = [
            'total_count' => 0,
            'items' => []
        ];
        $params = [
            'AbilityOwnSearch[name]' => Yii::$app->request->get('q')
        ];
        $searchModel = new AbilityOwnSearch();
        $dataProvider = $searchModel->search($params);

        $result['total_count'] = $dataProvider->getTotalCount();

        /** @var AbilityOwn $model */
        foreach ($dataProvider->models as $model) {
            $result['items'][] = [
                'id' => $model->magic_id,
                'name' => $model->name,
            ];
        }

        return Json::encode($result);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AbilityOwn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AbilityOwn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
