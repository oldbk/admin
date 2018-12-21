<?php

namespace frontend\modules\library\controllers;

use common\models\oldbk\LibraryPocket;
use common\models\oldbk\LibraryItem;
use common\models\oldbk\search\LibraryPocketSearch;
use common\helper\ShopHelper;
use frontend\components\AuthController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ItemController extends AuthController
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
     * Updates an existing LotoItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pocket_id)
    {
        $model = new LibraryItem();
	$model->pocket_id = $pocket_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/library/pocket/view','id' => $pocket_id]);
        }

	$shopList = ShopHelper::getShopList();

	unset($shopList[ShopHelper::TYPE_FSHOP]);

        return $this->render('create', [
            'model' => $model,
	    'shopList' => $shopList,
        ]);
    }

    /**
     * Deletes an existing LibraryItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $pocket_id = $model->pocket_id;
	$model->delete();
        return $this->redirect(['/library/pocket/view','id' => $pocket_id]);
    }

    /**
     * Finds the LibraryItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LibraryItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LibraryItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
