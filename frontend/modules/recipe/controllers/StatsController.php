<?php

namespace frontend\modules\recipe\controllers;

use common\models\oldbk\CraftStats;
use common\models\oldbk\query\CraftStatsQuery;
use frontend\components\AuthController;
use yii\helpers\Json;

class StatsController extends AuthController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCraftstartjson()
    {
        $chart = [];
        $Stats = CraftStats::find()
            ->select(' sum(`count`) as sum_count, date ')
            ->andWhere('date >= :datefrom', [':datefrom' => (new \DateTime())->modify('-1 month')->format('Y-m-d')])
	    ->andWhere('type = :type', [':type' => CraftStats::CRAFT_START])
	    ->groupBy('date')
            ->all();

        foreach ($Stats as $Stat) {
		$chart[$Stat->date] = $Stat->sum_count;
        }


        return Json::encode([
            'success' => true,
            'chart' => array_values($chart),
            'labels' => array_keys($chart)
        ]);
   }

    public function actionCraftekrjson()
    {
        $chart = [];
        $Stats = CraftStats::find()
            ->select(' sum(`countnumeric`) as sum_count, date ')
            ->andWhere('date >= :datefrom', [':datefrom' => (new \DateTime())->modify('-1 month')->format('Y-m-d')])
	    ->andWhere('type = :type', [':type' => CraftStats::CRAFT_EKR])
	    ->groupBy('date')
            ->all();

        foreach ($Stats as $Stat) {
		$chart[$Stat->date] = $Stat->sum_count;
        }


        return Json::encode([
            'success' => true,
            'chart' => array_values($chart),
            'labels' => array_keys($chart)
        ]);
   }


    public function actionCraftexpjson()
    {
        $chart = [];
        $Stats = CraftStats::find()
            ->select(' sum(`count`) as sum_count, date ')
            ->andWhere('date >= :datefrom', [':datefrom' => (new \DateTime())->modify('-1 month')->format('Y-m-d')])
	    ->andWhere('type = :type', [':type' => CraftStats::CRAFT_EXP])
	    ->groupBy('date')
            ->all();

        foreach ($Stats as $Stat) {
		$chart[$Stat->date] = $Stat->sum_count;
        }


        return Json::encode([
            'success' => true,
            'chart' => array_values($chart),
            'labels' => array_keys($chart)
        ]);
   }

    public function actionCrafttimejson()
    {
        $chart = [];
        $Stats = CraftStats::find()
            ->select(' sum(`count`) as sum_count, date ')
            ->andWhere('date >= :datefrom', [':datefrom' => (new \DateTime())->modify('-1 month')->format('Y-m-d')])
	    ->andWhere('type = :type', [':type' => CraftStats::CRAFT_TIME])
	    ->groupBy('date')
            ->all();

        foreach ($Stats as $Stat) {
		$chart[$Stat->date] = round($Stat->sum_count / (24*60),2);
        }


        return Json::encode([
            'success' => true,
            'chart' => array_values($chart),
            'labels' => array_keys($chart)
        ]);
   }

}
