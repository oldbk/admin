<?php

namespace frontend\modules\quest\controllers;

use common\helper\ShopHelper;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\QuestValidatorItem;
use common\models\oldbk\QuestValidatorItemInfo;
use common\models\oldbk\Shop;
use common\models\questPocket\QuestPocketTaskDo;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use common\models\questTask\DropTask;
use common\models\questTask\EventTask;
use common\models\questTask\FightTask;
use common\models\questTask\GiftTask;
use common\models\questTask\ItemTask;
use common\models\questTask\MagicTask;
use frontend\components\AuthController;
use Yii;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PartTaskController extends AuthController
{
    public function actions()
    {
        return [
            'drop'      => 'frontend\modules\quest\controllers\actions\partTask\DropAction',
            'item'      => 'frontend\modules\quest\controllers\actions\partTask\ItemAction',
            'fight'     => 'frontend\modules\quest\controllers\actions\partTask\FightAction',
            'gift'      => 'frontend\modules\quest\controllers\actions\partTask\GiftAction',
            'magic'     => 'frontend\modules\quest\controllers\actions\partTask\MagicAction',
            'hill'      => 'frontend\modules\quest\controllers\actions\partTask\HillAction',
            'event'     => 'frontend\modules\quest\controllers\actions\partTask\EventAction',
            'weight'    => 'frontend\modules\quest\controllers\actions\partTask\WeightAction',
            'buy'       => 'frontend\modules\quest\controllers\actions\partTask\BuyAction',
            'kill-bot'  => 'frontend\modules\quest\controllers\actions\partTask\kill\BotAction',
        ];
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
        $task_id = $model->pocket_item_id;

        try {
			QuestValidatorItemInfo::deleteAll('validator_parent_id = :id and validator_parent_type = "task"', [
				':id' => $model->id,
			]);
			QuestValidatorItem::deleteAll('parent_id = :id and parent_type = "task"', [
				':id' => $model->id,
			]);

            QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/part/view', 'id' => $task_id]);
    }
}
