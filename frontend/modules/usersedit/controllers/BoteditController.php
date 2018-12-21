<?php

namespace frontend\modules\usersedit\controllers;

use common\models\oldbk\search\UsersSearch;
use common\models\oldbk\Users;
use frontend\components\AuthController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class BoteditController extends AuthController
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionIndex() {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->searchBot(Yii::$app->request->queryParams);
	

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Users::find()->where(['bot' => 1, 'block' => 0, 'id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
