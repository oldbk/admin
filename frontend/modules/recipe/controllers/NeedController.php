<?php

namespace frontend\modules\recipe\controllers;

use common\models\Notepad;
use common\models\recipe\Recipe;
use common\models\recipe\RecipeItemInfo;
use common\models\recipe\RecipeItemNeed;
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
class NeedController extends AuthController
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
            'align'     => 'frontend\modules\recipe\controllers\actions\need\AlignAction',
            'userLevel'  => 'frontend\modules\recipe\controllers\actions\need\UserLevelAction',
            'profession'  => 'frontend\modules\recipe\controllers\actions\need\ProfessionAction',
            'ingredient'  => 'frontend\modules\recipe\controllers\actions\need\IngredientAction',
            'stat'  => 'frontend\modules\recipe\controllers\actions\need\StatAction',
            'vlad'  => 'frontend\modules\recipe\controllers\actions\need\VladAction',
        ];
    }

    /**
     * Deletes an existing QuestList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($item_id)
    {
        $Item = RecipeItemNeed::findOne($item_id);
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
