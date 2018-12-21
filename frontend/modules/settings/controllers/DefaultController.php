<?php

namespace frontend\modules\settings\controllers;

use common\models\Notepad;
use common\models\oldbk\search\DilerDeloSearch;
use common\models\oldbk\Settings;
use common\models\oldbk\Variables;
use common\models\QuestPocketItem;
use frontend\components\AuthController;
use GuzzleHttp\Client;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class DefaultController extends AuthController
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
        $Friday = Variables::find()
            ->andWhere('var = :var', [':var' => 'friday_time'])
            ->one();

        $TykvaBot = Variables::find()
            ->andWhere('var = :var', [':var' => 'tykvabot_time'])
            ->one();

        $Demontime = Variables::find()
            ->andWhere('var = :var', [':var' => 'demon_time'])
            ->one();

        $CP = Variables::find()
            ->andWhere('var = "cp_attack_time_start"')
            ->one();


        $temp = Settings::find()
            ->andWhere('`settings`.key = "volna_haos_start" or `settings`.key = "volna_haos_end"')
            ->all();
        $haos_start = $haos_end = null;
        foreach ($temp as $_item) {
            if($_item->key == 'volna_haos_start') {
                $haos_start = $_item;
            } else {
                $haos_end = $_item;
            }
        }

		$Notepad = Notepad::find()
			->andWhere('place = :place', [':place' => Notepad::PLACE_SETTINGS])
			->one();

        return $this->render('index', [
            'friday' => $Friday,
            'tykvabot' => $TykvaBot,
            'demontime' => $Demontime,
            'cp' => $CP,
            'haos_start' => $haos_start,
            'haos_end' => $haos_end,
			'notepad' => $Notepad
        ]);
    }

    public function actionDate($field)
    {
        $model = Variables::find()
            ->andWhere('var = :var', [':var' => $field])
            ->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->value = (new \DateTime($model->value))->getTimestamp();
            if(!$model->save()) {

            } else {
				$client = new Client();
				$client->request('GET', 'http://capitalcity.oldbk.com/action/api/settingsCache?key=XTVoEUoiDpAeGNQz6rFHGM5vbH');
			}

            return $this->redirect(['/settings/default/index']);
        }

        return $this->renderAjax('date', ['model' => $model]);
    }

    public function actionHaos()
    {
        $temp = Settings::find()
            ->andWhere('`settings`.key = "volna_haos_start" or `settings`.key = "volna_haos_end"')
            ->all();
        $haos_start = $haos_end = null;
        foreach ($temp as $_item) {
            if($_item->key == 'volna_haos_start') {
                $haos_start = $_item;
            } else {
                $haos_end = $_item;
            }
        }

        if ($haos_start->load(Yii::$app->request->post(), 'Settings1') && $haos_end->load(Yii::$app->request->post(), 'Settings2')) {
            $haos_start->value = (new \DateTime($haos_start->value))->getTimestamp();
            $haos_end->value = (new \DateTime($haos_end->value))->getTimestamp();
            if(!$haos_start->save() || !$haos_end->save()) {
                
            } else {
				$client = new Client();
				$client->request('GET', 'http://capitalcity.oldbk.com/action/api/settingsCache?key=XTVoEUoiDpAeGNQz6rFHGM5vbH');
			}

            return $this->redirect(['/settings/default/index']);
        }

        return $this->renderAjax('haos', [
            'haos_start' => $haos_start,
            'haos_end' => $haos_end,
        ]);
    }
}
