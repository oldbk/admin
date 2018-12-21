<?php

namespace frontend\modules\library\controllers;

use frontend\components\AuthController;
use Yii;
use common\models\oldbk\LibraryCategory;
use common\models\oldbk\search\LibrarySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for LibraryCategory model.
 */
class CategoryController extends AuthController
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
     * Lists all LibraryCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibrarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy('order_position asc');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new LibraryCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LibraryCategory();

        if ($model->load(Yii::$app->request->post())) {
            $LastDialog = LibraryCategory::find()
                ->orderBy('order_position desc')
                ->one();
            $position = 1;
            if($LastDialog) {
                $position = $LastDialog->order_position + 1;
            }
            $model->order_position = $position;
            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LibraryCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LibraryCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUp($id)
    {
        $Category = $this->findModel($id);
        $PrevDialog = LibraryCategory::find()
            ->andWhere('order_position = :position', [
                ':position' => $Category->order_position - 1,
            ])
            ->one();
        if($PrevDialog) {
            $t = Yii::$app->db->beginTransaction();
            try {

                $Category->order_position -= 1;
                if(!$Category->save(false)) {
                    throw new \Exception;
                }

                $PrevDialog->order_position += 1;
                if(!$PrevDialog->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(['/library/category/index']);
    }

    public function actionDown($id)
    {
        $Category = $this->findModel($id);
        $NextDialog = LibraryCategory::find()
            ->andWhere('order_position = :position', [
                ':position' => $Category->order_position + 1,
            ])
            ->one();
        if($NextDialog) {
            $t = Yii::$app->db->beginTransaction();
            try {
                $Category->order_position += 1;
                if(!$Category->save(false)) {
                    throw new \Exception;
                }

                $NextDialog->order_position -= 1;
                if(!$NextDialog->save(false)) {
                    throw new \Exception;
                }

                $t->commit();
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->redirect(['/library/category/index']);
    }

    /**
     * Finds the LibraryCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LibraryCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LibraryCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
