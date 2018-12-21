<?php

namespace frontend\modules\recipe\controllers;

use common\models\Notepad;
use common\models\recipe\Recipe;
use common\models\recipe\RecipeItemGive;
use common\models\recipe\RecipeItemInfo;
use common\models\search\RecipeSearch;

use common\models\QuestCondition;
use common\models\questCondition\BaseCondition;
use common\models\QuestPart;
use frontend\components\AuthController;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestController implements the CRUD actions for QuestList model.
 */
class GiveController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        return $parent;
    }

    public function actions()
    {
        return [
            'exp'       => 'frontend\modules\recipe\controllers\actions\give\ExpAction',
            'item'      => 'frontend\modules\recipe\controllers\actions\give\ItemAction',
        ];
    }

    public function actionDelete($item_id)
    {
        $Item = RecipeItemGive::findOne($item_id);
        if(!$Item) {
            throw new HttpException(404, 'Требование не найдено');
        }

        $t = Yii::$app->db->beginTransaction();
        try {
            RecipeItemInfo::deleteAll('item_id = :item_id', [':item_id' => $Item->id]);
            $Item->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/recipe/recipe/view', 'id' => $Item->recipe_id]);
    }

    /**
     * Finds the QuestList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
