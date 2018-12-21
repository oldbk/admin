<?php

namespace frontend\modules\library\controllers;

use common\models\oldbk\LibraryPocket;
use common\models\oldbk\LibraryItem;
use common\models\oldbk\search\LibraryPocketSearch;
use common\models\oldbk\Shop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Cshop;
use common\helper\ShopHelper;
use frontend\components\AuthController;
use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PocketController extends AuthController
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
     * Lists all LibraryItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibraryPocketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all LotoItem models.
     * @return mixed
     */
    public function actionView($id)
    {

        $query = new Query();
        $query2 = new Query();
        $query3 = new Query();

        $query -> select("i.*,s.name")->from(LibraryItem::tableName().' i')->leftJoin( Shop::tableName(). ' s','s.id = item_id')->where(['shop_id' => ShopHelper::TYPE_SHOP ])->andWhere(['pocket_id' => $id]);
        $query2-> select("i.*,s.name")->from(LibraryItem::tableName().' i')->leftJoin(Eshop::tableName(). ' s','s.id = item_id')->where(['shop_id' => ShopHelper::TYPE_ESHOP])->andWhere(['pocket_id' => $id]);
        $query3-> select("i.*,s.name")->from(LibraryItem::tableName().' i')->leftJoin(Cshop::tableName(). ' s','s.id = item_id')->where(['shop_id' => ShopHelper::TYPE_CSHOP])->andWhere(['pocket_id' => $id]);
        
        $query -> union($query2);
        $query -> union($query3);

       	$dataProvider = new ActiveDataProvider([
		'query' => $query,
		'db' => 'db_oldbk',
	]);

	$dataProvider->pagination->pageSize = 0;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
	    'shopList' => ShopHelper::getShopList(),
        ]);           
    }

    /**
     * Updates an existing LotoItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LibraryPocket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/library/pocket/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/library/pocket/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing LotoItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        try {

            $this->findModel($id)->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['index']);
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
        if (($model = LibraryPocket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
