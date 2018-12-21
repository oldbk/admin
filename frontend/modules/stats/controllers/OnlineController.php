<?php

namespace frontend\modules\stats\controllers;

use common\models\QuestPocketItem;
use common\models\search\StatOnlineSearch;
use common\models\StatOnline;
use frontend\components\AuthController;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class OnlineController extends AuthController
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

    public function actionJson()
    {
        $chart = [];
        /** @var StatOnline[] $Stats */
        $Stats = StatOnline::find()
            ->andWhere('updated_at >= :updated_at', [':updated_at' => (new \DateTime())->modify('-1 month')->getTimestamp()])
            ->all();
        foreach ($Stats as $Stat) {
            $label = (new \DateTime())->setTimestamp($Stat->datetime)->format('d/m');

            if(!isset($chart[$label])) {
                $chart[$label] = 0;
            }

            if($Stat->count > $chart[$label]) {
                $chart[$label] = (int)$Stat->count;
            }
        }

        return Json::encode([
            'success' => true,
            'chart' => array_values($chart),
            'labels' => array_keys($chart)
        ]);
    }

    public function actionJson2()
    {
        $chart = [];
        /** @var StatOnline[] $Stats */
        $Stats = StatOnline::find()
            ->andWhere('updated_at >= :updated_at', [':updated_at' => (new \DateTime())->modify('-1 month')->getTimestamp()])
            ->all();
        $lastDate = [];
        foreach ($Stats as $Stat) {
            $label = (new \DateTime())->setTimestamp($Stat->datetime)->format('d/m');

            if(!isset($chart[$label])) {
                $chart[$label] = 0;
            }

            if($Stat->count > $chart[$label]) {
                $chart[$label] = (int)$Stat->count;
                $lastDate[$label] = (new \DateTime())->setTimestamp($Stat->datetime);
            }
        }

        $newChart = [];
        foreach ($chart as $label => $count) {
            $datetime = $lastDate[$label];
            $newChart[$datetime->format('d/m H:i')] = $count;
        }

        return Json::encode([
            'success' => true,
            'chart' => array_values($newChart),
            'labels' => array_keys($newChart)
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
        if (($model = StatOnline::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
