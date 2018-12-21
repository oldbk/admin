<?php

namespace frontend\modules\loto\controllers;

use common\models\oldbk\ItemLoto;
use common\models\oldbk\Shop;
use common\models\loto\LotoItem;
use frontend\components\AuthController;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for LotoItem model.
 */
class StatController extends AuthController
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
     * Lists all LotoItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => ItemLoto::find()
                ->select('*')
                ->addSelect('count(*) as ticket_count')
                ->addSelect('sum(cost_kr) as sum_kr')
                ->addSelect('sum(cost_ekr) as sum_ekr')
                ->groupBy('loto')
                ->orderBy('loto desc')
                ->all()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the LotoItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LotoItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LotoItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
