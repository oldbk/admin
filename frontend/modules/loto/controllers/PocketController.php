<?php

namespace frontend\modules\loto\controllers;

use common\helper\CurrencyHelper;
use common\models\loto\LotoExport;
use common\models\loto\LotoItemInfo;
use common\models\loto\LotoPocket;
use common\models\oldbk\Shop;
use common\models\search\LotoExportSearch;
use common\models\search\LotoItemSearch;
use common\models\search\LotoPocketSearch;
use frontend\components\AuthController;
use Yii;
use common\models\loto\LotoItem;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for LotoItem model.
 */
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
     * Lists all LotoItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LotoPocketSearch(['scenario' => LotoPocket::SCENARIO_SEARCH]);
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
        $Pocket = $this->findModel($id);

        $searchModel = new LotoItemSearch(['scenario' => LotoItem::SCENARIO_SEARCH]);
        $searchModel->pocket_id = $id;
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);

        $searchExport = new LotoExportSearch();
        $searchExport->pocket_id = $id;
        $dataProviderExport = $searchExport->search([]);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchExport' => $searchExport,
            'dataProviderExport' => $dataProviderExport,
            'Pocket' => $Pocket,
        ]);
    }

    /**
     * Updates an existing LotoItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LotoPocket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/loto/pocket/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/loto/pocket/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionExport($id, $loto_num)
    {
        if(!is_numeric($loto_num)) {
            return Json::encode([
                'error' => true,
                'messages' => [
                    ['title' => 'Операция завершена с ошибкой', 'text' => '№ тиража должен быть числом']
                ]
            ]);
        }

        $Pocket = $this->findModel($id);
        if(!$Pocket) {
            return Json::encode([
                'error' => true,
                'messages' => [
                    ['title' => 'Операция завершена с ошибкой', 'text' => 'Список не найден']
                ]
            ]);
        }

        $Items = LotoItem::find()
            ->with('lotoItemInfos')
            ->andWhere('pocket_id = :pocket_id', [':pocket_id' => $id])
            ->all();

        $LotoExport = new LotoExport();
        $LotoExport->pocket_id = $Pocket->id;
        $LotoExport->user_id = \Yii::$app->user->id;
        $LotoExport->loto_num = $loto_num;
        $LotoExport->save();

        $t_oldbk = Yii::$app->db_oldbk->beginTransaction();
        try {
            \common\models\oldbk\LotoItemInfo::deleteAll('loto_num = :loto_num', [':loto_num' => $loto_num]);
            \common\models\oldbk\LotoItem::deleteAll('loto_num = :loto_num', [':loto_num' => $loto_num]);

            foreach ($Items as $Item) {
                $LotoItem = new \common\models\oldbk\LotoItem();
                $LotoItem->id = $Item->id;
                $LotoItem->loto_num = $loto_num;
                $LotoItem->stock = $Item->stock;
                $LotoItem->created_at = time();
                $LotoItem->cost_kr = $Item->cost_type == CurrencyHelper::CURRENCY_KR ? $Item->cost : 0;
                $LotoItem->cost_ekr = $Item->cost_type == CurrencyHelper::CURRENCY_EKR ? $Item->cost : 0;
                $LotoItem->item_name = $Item->item_name;
                $LotoItem->count = $Item->count;
                $LotoItem->category_id = $Item->category_id;
                if(!$LotoItem->save()) {
                    throw new \Exception();
                }

                $rows = [];
                foreach ($Item->info->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'loto_num'  => $loto_num,
                        'item_id'   => $Item->id,
                        'field'     => $field,
                        'value'     => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db_oldbk->createCommand()
                        ->batchInsert(\common\models\oldbk\LotoItemInfo::tableName(), (new \common\models\oldbk\LotoItemInfo())->attributes(), $rows)->execute();
                }
            }

            $t_oldbk->commit();

            return Json::encode([
                'success' => true,
                'messages' => [
                    ['title' => 'Операция завершена', 'text' => 'Успешно эксапортировали новые предметы для лото']
                ],
                'exported_at' => (new \DateTime())->setTimestamp($LotoExport->exported_at)->format('d.m.Y H:i')
            ]);
        } catch (\Exception $ex) {
            $t_oldbk->rollBack();

            return Json::encode([
                'error' => true,
                'messages' => [
                    ['title' => 'Операция завершена с ошибкой', 'text' => $ex->getMessage()]
                ]
            ]);
        }
    }

    public function actionClone($id)
    {
        $t = Yii::$app->db->beginTransaction();
        try {
            $Pocket = LotoPocket::find()
                ->andWhere('id = :id', [':id' => $id])
                ->with(['lotoItems', 'lotoItems.lotoItemInfos'])
                ->one();

            $NewPocket = new LotoPocket();
            $NewPocket->name = 'Копия '.$Pocket->name;
            if(!$NewPocket->save()) {
				throw new \Exception('Can\'t save pocket');
            }

            foreach ($Pocket->lotoItems as $LotoItem) {
                $data = $LotoItem->getAttributes();
                unset($data['created_at'], $data['updated_at'], $data['id']);

                $NewLotoItem = new LotoItem();
                $NewLotoItem->setAttributes($data, false);
                $NewLotoItem->pocket_id = $NewPocket->id;
                if(!$NewLotoItem->save()) {
                    throw new \Exception('Can\'t save item');
                }

                foreach ($LotoItem->lotoItemInfos as $LotoItemInfo) {
                    $NewLotoItemInfo            = new LotoItemInfo();
                    $NewLotoItemInfo->pocket_id = $NewPocket->id;
                    $NewLotoItemInfo->item_id   = $NewLotoItem->id;
                    $NewLotoItemInfo->field     = $LotoItemInfo->field;
                    $NewLotoItemInfo->value     = $LotoItemInfo->value;
                    if(!$NewLotoItemInfo->save()) {
						throw new \Exception('Can\'t save item info ');
                    }
                }
            }

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
            var_dump($ex->getMessage());die;
        }

        return $this->redirect(['index']);
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
            LotoItemInfo::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $id]);

            LotoItem::deleteAll('pocket_id = :pocket_id', [':pocket_id' => $id]);

            $this->findModel($id)->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['index']);
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
        if (($model = LotoPocket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
