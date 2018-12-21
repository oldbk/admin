<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace frontend\modules\quest\controllers\actions\rewardValidator;

use common\models\QuestPocketItem;
use common\models\validator\QuestValidatorItemInfo;
use common\models\validator\QuestValidatorItemReward;
use common\models\validatorItem\UserValidator;
use yii\base\Action;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;

class UserAction extends Action
{
    public function run($id)
    {
        $PocketReward = QuestPocketItem::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$PocketReward) {
            throw new HttpException(404, 'Задание не найдено');
        }

        $item = new UserValidator();

        $model = new QuestValidatorItemReward();
        $model->parent_id = $PocketReward->id;
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
                    if(!$value && $value != 0 || $value == '') {
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
                if(!$rows) {
                    throw new \Exception();
                }

                $r = Yii::$app->db->createCommand()
                    ->batchInsert(QuestValidatorItemInfo::tableName(), (new QuestValidatorItemInfo)->attributes(), $rows)->execute();

                $t->commit();

                return $this->controller->redirect(['/quest/part/view', 'id' => $PocketReward->pocket_item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->controller->render('user/create', [
            'model' => $model,
            'item'  => $item,
            'backLink' => Url::to(['/quest/part/view', 'id' => $PocketReward->pocket_item_id]),
        ]);
    }
}