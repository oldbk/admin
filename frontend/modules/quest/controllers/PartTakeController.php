<?php

namespace frontend\modules\quest\controllers;

use common\helper\ShopHelper;
use common\models\itemInfo\ItemInfo;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Shop;
use common\models\questPocket\QuestPocketPartTake;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use frontend\components\AuthController;
use Yii;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PartTakeController extends AuthController
{
    /**
     * @param $id //PocketID
     */
    public function actionItem($id)
    {
        $Pocket = QuestPocketPartTake::find()
            ->with('part')
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Pocket) {
            throw new HttpException(404, 'Список не найден');
        }

        $model = new QuestPocketItem();
        $model->pocket_id = $Pocket->id;
        $model->pocket_item_id = $Pocket->item_id;
        $model->pocket_item_type = $Pocket->item_type;

        $item = new ItemInfo();

        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());
        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if($item->item_id) {
                    /** @var Shop|Eshop|Cshop $OldbkItem */
                    $OldbkItem = ShopHelper::getItemByShopId($item->shop_id, ['id' => $item->item_id]);
                    if(!$OldbkItem) {
                        throw new HttpException('Предмет не найден');
                    }
                    $item->name = $OldbkItem->name;
                }

                $model->item_type = $item->getItemType();
                if(!$model->save()) {
                    throw new \Exception();
                }

                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'item_id'           => $model->id,
                        'field'             => $field,
                        'value'             => $value,
                        'pocket_id'         => $model->pocket_id,
                        'pocket_item_id'    => $model->pocket_item_id,
                        'pocket_item_type'  => $model->pocket_item_type,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(QuestPocketItemInfo::tableName(), (new QuestPocketItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('item/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }
    
    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        $model = QuestPocketItem::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();

        if(!$model) {
            return false;
        }
        $part_id = $model->pocket_item_id;

        try {
            QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/part/view', 'id' => $part_id]);
    }
}
