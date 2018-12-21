<?php

namespace frontend\modules\dialog\controllers;

use common\models\dialog\Dialog;
use common\models\dialog\DialogPart;
use common\models\dialog\DialogQuest;
use common\models\query\DialogQuery;
use common\models\Quest;
use Yii;
use common\models\DialogAction;
use common\models\search\DialogActionSearch;
use frontend\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActionController implements the CRUD actions for DialogAction model.
 */
class TreeController extends AuthController
{
    /**
     * Lists all DialogQuest models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $Quest = Quest::find()
            ->with([
                'questParts' => function($query) {
                    $query->indexBy('id');
                }
            ])
            ->indexBy('id')
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Quest) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $DialogQuest = Dialog::find()
            ->with(['questDialogActions', 'bot'])
            ->andWhere('global_parent_id = :global_parent_id', [':global_parent_id' => $Quest->id])
            ->orderBy('order_position asc')
            ->all();

        return $this->render('index', [
            'Quest' => $Quest,
            'DialogQuest' => $DialogQuest,
        ]);
    }
}
