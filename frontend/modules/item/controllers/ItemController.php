<?php
namespace frontend\modules\item\controllers;

use common\helper\ShopHelper;
use common\models\CustomItem;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Magic;
use common\models\oldbk\Shop;
use common\models\search\CustomItemSearch;
use frontend\components\AuthController;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Site controller
 */
class ItemController extends AuthController
{
    public function actionSearch()
    {
        $result = [
            'total_count' => 0,
            'items' => []
        ];
        $params = [
            'name' => Yii::$app->request->get('q')
        ];
        $params = ArrayHelper::merge($params, Yii::$app->request->get('params', []));
        if($shop_id = Yii::$app->request->get('shop_id')) {
            $dataProvider = ShopHelper::searchByShopId($shop_id, $params);
        } else {
            $dataProvider = ShopHelper::search($params);
        }

        if(!$dataProvider) {
            return Json::encode($result);
        }

        $result['total_count'] = $dataProvider->getTotalCount();

        /** @var Shop $model */
        foreach ($dataProvider->models as $model) {
            $result['items'][] = [
                'name' => $model->name,
                'id' => $model->id,
                'cost' => $model->cost,
                'ecost' => $model->ecost,
                'dur'   => $model->duration,
                'maxdur' => $model->maxdur
            ];
        }

        return Json::encode($result);
    }

    public function actionShow($item_id, $shop_id)
    {
        $params = [
            'id' => $item_id
        ];
        $dataProvider = ShopHelper::searchByShopId($shop_id, $params);
        /** @var Shop|Eshop|Cshop $model */
        $model = array_shift($dataProvider->getModels());
        $model->shop_id = $shop_id;
        if($model->magic) {
            $model->magic_model = Magic::findOne($model->magic);
        }
        if($model->includemagic) {
            $model->include_magic_model = Magic::findOne($model->includemagic);
        }

        $content = $this->renderPartial('ajax/_show', [
            'model' => $model,
        ]);

        return Json::encode([
            'success' => true,
            'content' => $content
        ]);
    }

    public function actionCustomSearch()
    {
        $result = [
            'total_count' => 0,
            'items' => []
        ];
        $params = [
            'CustomItemSearch[name]' => Yii::$app->request->get('q')
        ];
        $searchModel = new CustomItemSearch();
        $dataProvider = $searchModel->search($params);

        $result['total_count'] = $dataProvider->getTotalCount();

        /** @var CustomItem $model */
        foreach ($dataProvider->models as $model) {
            $result['items'][] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }

        return Json::encode($result);
    }
}
