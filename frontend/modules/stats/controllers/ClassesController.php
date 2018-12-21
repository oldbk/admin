<?php

namespace frontend\modules\stats\controllers;

use \common\models\oldbk\Users;
use frontend\components\AuthController;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class ClassesController extends AuthController
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
	$users = Users::getClassesStats();

	$allcnt = 0;
	foreach ($users as $key => $user) {
		$users[$key]['name'] = Users::nclass_name[$user['uclass']];
		$allcnt += $user['cnt'];
	}                     

	$users[-1]['name'] = 'Все классы';
	$users[-1]['cnt'] = $allcnt;

	$provider = new ArrayDataProvider([
	        'allModels' => $users,
	]);

	return $this->render('index', [
		'stats' => $provider,
	]);
    }

}
