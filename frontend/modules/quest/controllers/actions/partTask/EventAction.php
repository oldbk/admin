<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace frontend\modules\quest\controllers\actions\partTask;

use common\models\questPocket\QuestPocketPartTask;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use common\models\questTask\EventTask;
use yii\base\Action;
use Yii;
use yii\web\HttpException;

class EventAction extends Action
{
    public function run($id)
    {
        $Pocket = QuestPocketPartTask::find()
            ->with('part')
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Pocket) {
            throw new HttpException(404, 'Список не найден');
        }

        $item_id = Yii::$app->request->get('item_id', null);
        if($item_id) {
            $model = QuestPocketItem::findOne($item_id);
            if(!$model) {
                throw new HttpException(404, 'Задание не найдено');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new EventTask();
        }

        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());

        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
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

                return $this->controller->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->controller->render('event/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }
}