<?php

namespace frontend\modules\wordfilter\controllers;

use frontend\components\AuthController;
use Yii;
use common\models\oldbk\Forum;
use common\models\oldbk\search\ForumSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ForumfilterController implements the CRUD actions for Forumfilter model.
 */
class ForumcleanerController extends AuthController
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

    /**
     * Lists all Wordfilter models.
     * @return mixed
     */
    public function actionDelete()
    {
	$model = new ForumSearch();
	$model->load(Yii::$app->request->queryParams);

	if (strlen($model->a_info) || strlen($model->text)) {
	        $todel = Forum::find()
			->where(['like', 'a_info', $model->a_info])
			->andwhere(['like', 'text', $model->text])
			->all();
	
		$delarr = [];
		foreach ($todel as $rec) {
			$delarr[] = $rec['id'];
		}
	
		$sql = Forum::getDb()->createCommand('DELETE FROM `'.Forum::tableName().'` WHERE id IN ('.implode(",",$delarr).')');
		$sql->execute();
	}

	return $this->redirect(['index']);
	
    }

    public function actionIndex()
    {
        $searchModel = new ForumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	if (strlen($searchModel->a_info) || strlen($searchModel->text)) {
	 	$dataProvider->pagination->pageSize = 0;

	        return $this->render('index', [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
	        ]);
	} else {

	        return $this->render('index', [
	            'searchModel' => $searchModel,
	            'dataProvider' => NULL,
	        ]);
	}
    }

    protected function findModel($id)
    {
        if (($model = Wordfilter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
