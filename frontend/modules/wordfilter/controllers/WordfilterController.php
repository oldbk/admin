<?php

namespace frontend\modules\wordfilter\controllers;

use frontend\components\AuthController;
use Yii;
use common\models\oldbk\Wordfilter;
use common\models\oldbk\search\WordfilterSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WordfilterController implements the CRUD actions for Wordfilter model.
 */
class WordfilterController extends AuthController
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
    public function actionIndex()
    {
        $searchModel = new WordfilterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Wordfilter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $rows = array();
	$model = new Wordfilter;

	$data = Yii::$app->request->post();
	if (isset($data['Wordfilter']['word']) && !empty($data['Wordfilter']['word'])) {
		$datae = explode(",",$data['Wordfilter']['word']);
		foreach($datae as $word) {
			$rows[] = [
				'id' => NULL,
				'word' => trim(mb_strtolower($word)),
				'onlyfull' => isset($data['Wordfilter']['onlyfull']) && $data['Wordfilter']['onlyfull'] == 1 ? 1 : 0,
				'created_at' => time(),
				'updated_at' => time(),
			];
		}

	        if(count($rows)) {
			$sql = Wordfilter::getDb()->createCommand()
	                	->batchInsert(Wordfilter::tableName(), $model->attributes(), $rows)->getSql();
			$sql = implode("INSERT IGNORE INTO ", mb_split("INSERT INTO",$sql));
			Wordfilter::getDb()->createCommand($sql)->execute();
	        }

		return $this->redirect(['index']);
	} else {
		return $this->render('create', [
			'model' => $model,
		]);
	}
    }

    /**
     * Deletes an existing Wordfilter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteall()
    {
        Wordfilter::deleteAll();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Wordfilter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Wordfilter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wordfilter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
