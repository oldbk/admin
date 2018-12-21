<?php

namespace frontend\modules\ko\controllers;

use common\models\Notepad;
use common\models\oldbk\ConfigKoSettings;
use common\models\oldbk\search\ConfigKoSettingsSearch;
use frontend\components\AuthController;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class SettingsController extends AuthController
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
	 * @param $id
	 */
    public function actionList($id)
	{
		$searchModel = new ConfigKoSettingsSearch(['scenario' => ConfigKoSettingsSearch::SCENARIO_SEARCH]);
		$searchModel->main_id = $id;

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->renderPartial('ajax/_list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new QuestList model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($id)
	{
		$group_id = 0;
		$Last = ConfigKoSettings::find()
			->where('main_id = :main_id', [':main_id' => $id])
			->orderBy(['group_id' => SORT_DESC])
			->one();
		if($Last) {
			$group_id = $Last->group_id + 1;
		}
		$configData = Yii::$app->request->post('Config', []);
		if($configData) {
			$rows = [];
			foreach ($configData as $_item) {
				switch ($_item['type']) {
					case ConfigKoSettings::TYPE_DATETIMEPICKER:
						$_item['value'] = strtotime($_item['value']);
						break;
				}

				$rows[] = [
					'main_id' 		=> $id,
					'group_id' 		=> $group_id,
					'field_name' 	=> $_item['name'],
					'field_value' 	=> $_item['value'],
					'field_type' 	=> $_item['type'],
				];
			}

			if($rows) {
				ConfigKoSettings::getDb()->createCommand()
					->batchInsert(ConfigKoSettings::tableName(), (new ConfigKoSettings)->attributes(), $rows)->execute();
			}
			return Json::encode([
				'status' => 1,
				'url' => Url::to(['/ko/config/view', 'id' => $id]),
			]);
		}


		return $this->render('create', ['main_id' => $id]);
	}

	public function actionUpdate($id, $group_id)
	{
		/** @var ConfigKoSettings[] $Items */
		$Items = ConfigKoSettings::find()
			->where('main_id = :main_id and group_id = :group_id', [':main_id' => $id, ':group_id' => $group_id])
			->all();
		if(!$Items) {
			die('Ничего не нашли');
		}

		$configData = Yii::$app->request->post('Config', []);
		if($configData) {
			ConfigKoSettings::deleteAll('main_id = :main_id and group_id = :group_id', [':main_id' => $id, ':group_id' => $group_id]);

			$rows = [];
			foreach ($configData as $_item) {
				switch ($_item['type']) {
					case ConfigKoSettings::TYPE_DATETIMEPICKER:
						$_item['value'] = strtotime($_item['value']);
						break;
				}

				$rows[] = [
					'main_id' 		=> $id,
					'group_id' 		=> $group_id,
					'field_name' 	=> $_item['name'],
					'field_value' 	=> $_item['value'],
					'field_type' 	=> $_item['type'],
				];
			}

			if($rows) {
				ConfigKoSettings::getDb()->createCommand()
					->batchInsert(ConfigKoSettings::tableName(), (new ConfigKoSettings)->attributes(), $rows)->execute();
			}
			return Json::encode([
				'status' => 1,
				'url' => Url::to(['/ko/config/view', 'id' => $id]),
			]);
		}
		$items = [];
		foreach ($Items as $_item) {
			$value = $_item->field_value;
			switch ($_item->field_type) {
				case ConfigKoSettings::TYPE_DATETIMEPICKER:
					$value = date('Y-m-d H:i:s', $value);
					break;
			}

			$items[] = [
				'name' 	=> $_item->field_name,
				'value' => Html::encode($value),
				'type' 	=> $_item->field_type,
			];
		}

		return $this->render('update', ['main_id' => $id, 'items' => $items]);
	}

	public function actionClone($id, $group_id)
	{
		/** @var ConfigKoSettings[] $Items */
		$Items = ConfigKoSettings::find()
			->where('main_id = :main_id and group_id = :group_id', [':main_id' => $id, ':group_id' => $group_id])
			->all();
		if(!$Items) {
			die('Ничего не нашли');
		}
		$last = ConfigKoSettings::find()
			->where('main_id = :main_id', [':main_id' => $id])
			->orderBy(['group_id' => SORT_DESC])
			->one();
		if(!$last) {
			die('Ничего не нашли');
		}
		$group_id = $last->group_id + 1;

		$rows = [];
		foreach ($Items as $_item) {
			$rows[] = [
				'main_id' 		=> $id,
				'group_id' 		=> $group_id,
				'field_name' 	=> $_item->field_name,
				'field_value' 	=> $_item->field_value,
				'field_type' 	=> $_item->field_type,
			];
		}

		if($rows) {
			ConfigKoSettings::getDb()->createCommand()
				->batchInsert(ConfigKoSettings::tableName(), (new ConfigKoSettings)->attributes(), $rows)->execute();
		}


		$this->redirect(['/ko/config/view', 'id' => $id]);
	}

	public function actionDelete($id, $group_id)
	{
		ConfigKoSettings::deleteAll('main_id = :main_id and group_id = :group_id', [':main_id' => $id, ':group_id' => $group_id]);
		$this->redirect(['/ko/config/view', 'id' => $id]);
	}

	/**
	 * Finds the QuestList model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ConfigKoSettings the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ConfigKoSettings::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
