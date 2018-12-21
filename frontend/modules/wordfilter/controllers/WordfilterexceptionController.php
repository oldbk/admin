<?php

namespace frontend\modules\wordfilter\controllers;

use frontend\components\AuthController;
use Yii;
use common\models\oldbk\WordfilterException;
use common\models\oldbk\search\WordfilterExceptionSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WordfilterExceptionController implements the CRUD actions for Wordfilter model.
 */
class WordfilterexceptionController extends AuthController
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
     * Lists all WordfilterException models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WordfilterExceptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new WordfilterException model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $rows = array();
	$model = new WordfilterException;

	$data = Yii::$app->request->post();
	if (isset($data['WordfilterException']['word']) && !empty($data['WordfilterException']['word'])) {
		$datae = explode(",",$data['WordfilterException']['word']);
		foreach($datae as $word) {
			$rows[] = [
				'id' => NULL,
				'word' => trim(mb_strtolower($word)),
				'incsearch' => isset($data['WordfilterException']['incsearch']) && $data['WordfilterException']['incsearch'] == 1 ? 1 : 0,
				'created_at' => time(),
				'updated_at' => time(),
			];
		}

	        if(count($rows)) {
	            	$sql = WordfilterException::getDb()->createCommand()
	                	->batchInsert(WordfilterException::tableName(), $model->attributes(), $rows)->getSql();
			$sql = implode("INSERT IGNORE INTO ", mb_split("INSERT INTO",$sql));

			WordfilterException::getDb()->createCommand($sql)->execute();

	        }

		return $this->redirect(['index']);
	} else {
		return $this->render('create', [
			'model' => $model,
		]);
	}
    }

    /**
     * Deletes an existing WordfilterException model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionDeleteall()
    {
        WordfilterException::deleteAll();

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WordfilterException model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WordfilterException the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WordfilterException::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
