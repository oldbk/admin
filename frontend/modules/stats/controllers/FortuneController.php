<?php

namespace frontend\modules\stats\controllers;

use \common\models\oldbk\Users;
use \common\models\oldbk\UsersFortuneStats;
use frontend\components\AuthController;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use \common\helper\CurrencyHelper;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class FortuneController extends AuthController
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
        $goodrange = false;
	
	if ($range = Yii::$app->request->get("daterange")) {
		$t = explode("-",$range);
		if (count($t) == 2) {
			$t1 = explode("/",$t[0]);
			$t2 = explode("/",$t[1]);
			if (count($t1) == 3 && count($t2) == 3) {
				$range_start = mktime(0,0,0,$t1[1],$t1[0],$t1[2]);
				$range_end = mktime(23,59,59,$t2[1],$t2[0],$t2[2]);
				$goodrange = true;
			}
		}
	}
	if (!$goodrange) {
		$range_start = strtotime('first day of this month', time());
		$range_end = strtotime('last day of this month', time());
	}


	
	$stats = UsersFortuneStats::getStatusStat($range_start,$range_end);
	$sstats = [];
	$mstats = [];

	$mstats[CurrencyHelper::CURRENCY_KR]   = 0;
	$mstats[CurrencyHelper::CURRENCY_EKR]  = 0;
	$mstats[CurrencyHelper::CURRENCY_GOLD] = 0;

	foreach ($stats as $key => $stat) {
		$sstats[$key]['cc'] = $stat['cc'];
		$sstats[$key]['status'] = $stat['status']+1;
		$sstats[$key]['moneyone'] = 0;
		$sstats[$key]['moneytype'] = CurrencyHelper::CURRENCY_KR;

		switch($stat['status']) {
			case 0:
			break;
			case 1:
				$sstats[$key]['moneyone'] = 50;
				$sstats[$key]['moneytype'] = CurrencyHelper::CURRENCY_KR;
			break;
			case 2:
				$sstats[$key]['moneyone'] = 100;
				$sstats[$key]['moneytype'] = CurrencyHelper::CURRENCY_KR;
			break;
			case 3:
				$sstats[$key]['moneyone'] = 1;
				$sstats[$key]['moneytype'] = CurrencyHelper::CURRENCY_EKR;
			break;
			case 4:
				$sstats[$key]['moneyone'] = 3;
				$sstats[$key]['moneytype'] = CurrencyHelper::CURRENCY_EKR;
			break;
			case 5:
				$sstats[$key]['moneyone'] = 20;
				$sstats[$key]['moneytype'] = CurrencyHelper::CURRENCY_GOLD;
			break;
		}
		$sstats[$key]['money'] = $stat['cc'] * $sstats[$key]['moneyone'];
		$mstats[$sstats[$key]['moneytype']] += $sstats[$key]['money'];
	}                     

	$provider = new ArrayDataProvider([
	        'allModels' => $sstats,
	]);

	$uowner = UsersFortuneStats::getUnikOwnerStat($range_start,$range_end);
	if (!isset($uowner[0]['cc'])) $uowner[0]['cc'] = 0;
	$uowner = $uowner[0]['cc'];

	return $this->render('index', [
		'range_start' => $range_start,
		'range_end' => $range_end,
		'sstats' => $provider,
		'uowner' => $uowner,
		'mstats' => $mstats,
		'istats' => UsersFortuneStats::getItemStat($range_start,$range_end),
	]);
    }

}
