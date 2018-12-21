<?php

namespace frontend\modules\loto\controllers;

use common\helper\ShopHelper;
use common\models\AbilityOwn;
use common\models\CustomItem;
use common\models\itemInfo\AbilityInfo;
use common\models\itemInfo\CustomItemInfo;
use common\models\itemInfo\ItemInfo;
use common\models\loto\LotoItemInfo;
use common\models\loto\LotoPocket;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Shop;
use frontend\components\AuthController;
use GuzzleHttp\Client;
use Yii;
use common\models\loto\LotoItem;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for LotoItem model.
 */
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
                /*'actions' => [
                    'delete' => ['POST'],
                ],*/
            ],
        ];
    }

    /**
     * Creates a new LotoItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionItem($pocket_id)
    {
        $Pocket = LotoPocket::findOne($pocket_id);
        if(!$Pocket) {
            throw new HttpException(404, 'Список не найден');
        }

        $model = new LotoItem();
        $model->pocket_id = $Pocket->id;
        $item = new ItemInfo();

        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());
        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                /** @var Shop|Eshop|Cshop $OldbkItem */
                $OldbkItem = ShopHelper::getItemByShopId($item->shop_id, ['id' => $item->item_id]);
                if(!$OldbkItem) {
                    throw new HttpException('Предмет не найден');
                }

                $model->item_name = $item->getItemType();
                $model->item_info_name = $OldbkItem->name;
                if(!$model->save()) {
                    throw new \Exception();
                }

                $item->name = $OldbkItem->name;
                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'pocket_id' => $Pocket->id,
                        'item_id'   => $model->id,
                        'field'     => $field,
                        'value'     => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(LotoItemInfo::tableName(), (new LotoItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                return $this->redirect(['/loto/pocket/view', 'id' => $Pocket->id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'item'  => $item,
        ]);
    }

    public function actionAbility($pocket_id)
    {
        $Pocket = LotoPocket::findOne($pocket_id);
        if(!$Pocket) {
            throw new HttpException(404, 'Список не найден');
        }

        $model = new LotoItem();
        $model->pocket_id = $Pocket->id;
        $item = new AbilityInfo();

        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());
        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                /** @var AbilityOwn $Ability */
                $Ability = AbilityOwn::findOne($item->magic_id);
                if(!$Ability) {
                    throw new HttpException('Абилити не найдено');
                }

                $model->item_name = $item->getItemType();
                $model->item_info_name = $Ability->name;
                if(!$model->save()) {
                    throw new \Exception();
                }

                $item->name = $Ability->name;
                $item->count = $Ability->count;
                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'pocket_id' => $Pocket->id,
                        'item_id'   => $model->id,
                        'field'     => $field,
                        'value'     => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(LotoItemInfo::tableName(), (new LotoItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                return $this->redirect(['/loto/pocket/view', 'id' => $Pocket->id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'item'  => $item,
        ]);
    }

    public function actionCustom($pocket_id)
    {
        $Pocket = LotoPocket::findOne($pocket_id);
        if(!$Pocket) {
            throw new HttpException(404, 'Список не найден');
        }

        $model = new LotoItem();
        $model->pocket_id = $Pocket->id;
        $item = new CustomItemInfo();

        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());
        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                /** @var CustomItem $CustomItem */
                $CustomItem = CustomItem::findOne($item->item_id);
                if(!$CustomItem) {
                    throw new HttpException('Абилити не найдено');
                }

                $model->item_name = $item->getItemType();
                $model->item_info_name = $CustomItem->name;
                if(!$model->save()) {
                    throw new \Exception();
                }

                $item->name = $CustomItem->name;
                $item->get_method = $CustomItem->get_method;
                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'pocket_id' => $Pocket->id,
                        'item_id'   => $model->id,
                        'field'     => $field,
                        'value'     => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(LotoItemInfo::tableName(), (new LotoItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                return $this->redirect(['/loto/pocket/view', 'id' => $Pocket->id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'item'  => $item,
        ]);
    }

    /**
     * Updates an existing LotoItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $item = $model->info;

        $r1 = $model->load(Yii::$app->request->post());
        $item->load(Yii::$app->request->post());

        $success = false;
        if($r1) {
            $t = Yii::$app->db->beginTransaction();
            try {

                if(!$model->save()) {
                    throw new \Exception();
                }

                LotoItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'pocket_id' => $model->pocket_id,
                        'item_id'   => $model->id,
                        'field'     => $field,
                        'value'     => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(LotoItemInfo::tableName(), (new LotoItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                $model = $this->findModel($id);
                $item = $model->info;

                $success = true;
            } catch (\Exception $ex) {
                $t->rollBack();
                var_dump($ex->getMessage());die;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'item'  => $item,
            'success' => $success
        ]);
    }

    public function actionSimulation()
    {
        $client = new Client();
        $res = $client->request('GET', 'http://capitalcity.oldbk.com/action/tools/loto_simulation');
        $data = Json::decode($res->getBody()->getContents());

        $DataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10000
            ]
        ]);

        return $this->render('simulation', [
            'dataProvider' => $DataProvider,
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
        $model = $this->findModel($id);
        $pocket_id = $model->pocket_id;

        $t = Yii::$app->db->beginTransaction();
        try {
            LotoItemInfo::deleteAll('item_id = :item_id', [':item_id' => $id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/loto/pocket/view', 'id' => $pocket_id]);
    }

    /**
     * Finds the LotoItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LotoItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LotoItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
