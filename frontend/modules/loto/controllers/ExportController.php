<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 11.06.2018
 * Time: 22:52
 */

namespace frontend\modules\loto\controllers;
use common\models\loto\LotoItem;
use common\models\oldbk\WcEventItem;
use common\models\oldbk\WcEventItemDetails;
use frontend\components\AuthController;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Json;

class ExportController extends AuthController
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				/*'actions' => [
					'delete' => ['POST'],
				],*/
			],
		];
	}

	private $_wc_pool_grey 	= 60;
	private $_wc_pool_green = 61;

	public function actionWc()
	{
		$Items = LotoItem::find()
			->where(['in', 'pocket_id', [$this->_wc_pool_grey, $this->_wc_pool_green]])
			->with(['lotoItemInfos'])
			->all();

		$t = WcEventItem::getDb()->beginTransaction();
		try {
			WcEventItemDetails::deleteAll();
			WcEventItem::deleteAll();

			foreach ($Items as $Item) {
				$WcEventItem 				= new WcEventItem();
				$WcEventItem->id 			= $Item->id;
				$WcEventItem->item_name		= $Item->item_name;
				$WcEventItem->pocket_id 	= $Item->pocket_id;
				$WcEventItem->item_count 	= $Item->item_count;
				$WcEventItem->updated_at 	= time();
				if(!$WcEventItem->save()) {
					throw new \Exception();
				}

				foreach ($Item->lotoItemInfos as $info) {
					$WcEventItemDetails 			= new WcEventItemDetails();
					$WcEventItemDetails->pocket_id 	= $info->pocket_id;
					$WcEventItemDetails->item_id 	= $info->item_id;
					$WcEventItemDetails->field 		= $info->field;
					$WcEventItemDetails->value 		= $info->value;
					if(!$WcEventItemDetails->save()) {
						throw new \Exception();
					}
				}
			}

			$t->commit();

			return Json::encode([
				'success' => true,
				'messages' => [
					['title' => 'Операция завершена', 'text' => 'Успешно эксапортировали новые предметы ЧМ 2018']
				],
			]);

		} catch (\Exception $ex) {
			$t->rollBack();

			return Json::encode([
				'error' => true,
				'messages' => [
					['title' => 'Операция завершена с ошибкой', 'text' => $ex->getMessage()]
				]
			]);
		}
	}
}