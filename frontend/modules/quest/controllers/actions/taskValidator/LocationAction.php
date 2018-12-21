<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace frontend\modules\quest\controllers\actions\taskValidator;

use common\models\QuestPocketItem;
use common\models\validator\QuestValidatorItemInfo;
use common\models\validator\QuestValidatorItemTask;
use common\models\validatorItem\FightValidator;
use common\models\validatorItem\LocationValidator;
use yii\base\Action;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;

class LocationAction extends Action
{
    public function run($id)
    {
        $PocketTask = QuestPocketItem::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$PocketTask) {
            throw new HttpException(404, 'Задание не найдено');
        }

        $item = new LocationValidator();

        $model = new QuestValidatorItemTask();
        $model->parent_id = $PocketTask->id;
        $model->item_type = $item->getItemType();

        $r2 = $item->load(Yii::$app->request->post());

        if ($r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    QuestValidatorItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
                }

                if(!$model->save()) {
                    throw new \Exception();
                }

                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'item_id'               => $model->id,
                        'field'                 => $field,
                        'value'                 => $value,
                        'validator_item_type'   => $model->item_type,
                        'validator_parent_id'   => $model->parent_id,
                        'validator_parent_type' => $model->parent_type,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(QuestValidatorItemInfo::tableName(), (new QuestValidatorItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                return $this->controller->redirect(['/quest/part/view', 'id' => $PocketTask->pocket_item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->controller->render('location/create', [
            'model' => $model,
            'item'  => $item,
            'backLink' => Url::to(['/quest/part/view', 'id' => $PocketTask->pocket_item_id]),
        ]);
    }
}