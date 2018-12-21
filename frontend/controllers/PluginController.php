<?php

namespace frontend\controllers;

use common\models\oldbk\PluginAnalyze;
use common\models\oldbk\PluginUserWarning;
use common\models\oldbk\search\PluginUserWarningSearch;
use frontend\components\AuthController;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use Yii;

/**
 * ItemController implements the CRUD actions for LotoItem model.
 */
class PluginController extends AuthController
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

    public function actionOther()
    {
        $searchModel = new PluginUserWarningSearch(['scenario' => PluginUserWarning::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('other', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionLink()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => PluginAnalyze::find()
                ->select('*')
                ->andWhere('src is not null')
                ->all()
        ]);

        return $this->render('link', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChange($id, $type)
    {
        $Change = PluginAnalyze::findOne($id);
        if($Change) {
            $Change->is_correct = $Change->is_correct ? 0 : 1;
            $Change->save();
        }

        return $this->redirect(['/plugin/'.$type]);
    }

    public function actionClear($id)
    {
        $User = PluginUserWarning::findOne($id);
        if($User) {
            $User->count = 0;
            $User->save();
        }

        return $this->redirect(['/plugin/other']);
    }
}
