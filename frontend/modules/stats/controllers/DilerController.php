<?php

namespace frontend\modules\stats\controllers;

use common\models\Notepad;
use common\models\oldbk\search\DilerDeloSearch;
use common\models\QuestPocketItem;
use frontend\components\AuthController;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class DilerController extends AuthController
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
        $searchModel = new DilerDeloSearch();
        $searchModel->date = (new \DateTime('first day of this month'))->format('d/m/Y').' - '.(new \DateTime('last day of this month'))->format('d/m/Y');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $Notepad = Notepad::find()
            ->andWhere('place = :place', [':place' => Notepad::PLACE_DILER])
            ->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sum' => $searchModel->sum,
            'notepad' => $Notepad
        ]);
    }

    public function actionJson()
    {
        $searchModel = new DilerDeloSearch();
        $dataProvider = $searchModel->stats(Yii::$app->request->queryParams);

        $temp = $chart = [];
        foreach ($dataProvider->getModels() as $model) {
            $temp[$model->date_short] = $model->sum;
        }
        uksort($temp, function($a, $b){
            return (new \DateTime($a)) > (new \DateTime($b));
        });
        foreach ($temp as $date => $sum) {
            $chart[(new \DateTime($date))->format('d/m')] = $sum;
        }

        return Json::encode([
            'success' => true,
            'chart' => array_values($chart),
            'labels' => array_keys($chart)
        ]);
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
        if (($model = QuestPocketItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
