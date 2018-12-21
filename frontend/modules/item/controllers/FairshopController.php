<?php

namespace frontend\modules\item\controllers;

use common\helper\ShopHelper;
use common\models\Notepad;
use common\models\oldbk\DressroomItems;
use common\models\oldbk\search\shop\FairShopSearch;
use common\models\oldbk\Shop;
use frontend\components\AuthController;
use Yii;
use common\models\ItemCategory;
use common\models\search\ItemCategorySearch;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for ItemCategory model.
 */
class FairshopController extends AuthController
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
     * Lists all ItemCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FairShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query
			->with('dressroomItem');

		$Notepad = Notepad::find()
			->andWhere('place = :place', [':place' => Notepad::PLACE_FAIRSHOP])
			->one();

        return $this->render('index', [
            'searchModel' 	=> $searchModel,
            'dataProvider' 	=> $dataProvider,
			'notepad' 		=> $Notepad,
        ]);
    }

	/**
	 * Displays a single ItemCategory model.
	 * @param integer $id
	 * @param integer $category
	 * @return mixed
	 */
	public function actionDressroom($id)
	{
		$DressroomItem = DressroomItems::findOne(['item_id' => $id, 'shop_id' => ShopHelper::TYPE_FAIRSHOP]);
		if(!$DressroomItem) {
			$DressroomItem = new DressroomItems();
			$DressroomItem->item_id = $id;
			$DressroomItem->shop_id = ShopHelper::TYPE_FAIRSHOP;
		}

		if(Yii::$app->request->getIsAjax()) {
			$content = $this->renderPartial('_form', [
				'model' => $DressroomItem,
			]);

			return Json::encode([
				'success' => true,
				'content' => $content
			]);
		}

		if($DressroomItem->load(Yii::$app->request->post()) && $DressroomItem->save()) {

		}

		return $this->redirect(Yii::$app->request->getReferrer());
	}

    /**
     * Finds the ItemCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
