<?php

namespace frontend\modules\settings\controllers;

use common\models\Notepad;
use common\models\oldbk\search\DilerDeloSearch;
use common\models\oldbk\Settings;
use common\models\oldbk\Variables;
use common\models\QuestPocketItem;
use frontend\components\AuthController;
use frontend\models\settings\SettingsKlass;
use GuzzleHttp\Client;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class KlassController extends AuthController
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
    	$model = new SettingsKlass();

    	$model->load(Yii::$app->request->post());
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$error = false;
			$attributes = $model->getAttributes();
			$db = Settings::getDb();
			foreach ($attributes as $key => $value) {
				$t = $db->beginTransaction();

				try {
					/** @var Settings $Settings */
					$Settings = Settings::find()
						->where('`settings`.`key` = :key', [':key' => $key])
						->one();
					if(!$Settings) {
						$Settings = new Settings();
						$Settings->key = $key;
					}
					$Settings->value = str_replace(',', '.', $value);
					if(!$Settings->save()) {
						$model->addError($key, implode('<br>', $Settings->getErrors($key)));
						$error = true;
					}

					$t->commit();
				} catch (\Exception $ex) {
					$t->rollBack();
				}
			}

			if(!$error) {
				$client = new Client();
				$client->request('GET', 'http://capitalcity.oldbk.com/action/api/settingsCache?key=XTVoEUoiDpAeGNQz6rFHGM5vbH');
			}
		} else {
			/** @var Settings[] $temp */
			$temp = Settings::find()
				->andWhere('`settings`.`key` in ("klass_ratio_tank_uv", "klass_ratio_tank_krit", "klass_ratio_krit_uv", "klass_ratio_uv_krit")')
				->all();
			foreach ($temp as $_item) {
				$model->{$_item->key} = $_item->value;
			}
		}

		$Notepad = Notepad::find()
			->andWhere('place = :place', [':place' => Notepad::PLACE_SETTINGS_CLASS])
			->one();

        return $this->render('index', [
        	'model' => $model,
			'notepad' => $Notepad
		]);
    }
}
