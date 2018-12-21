<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace frontend\modules\recipe\controllers\actions\give;

use common\models\oldbk\CraftProf;
use common\models\recipe\give\RecipeGiveExp;
use common\models\recipe\Recipe;
use common\models\recipe\RecipeItemGive;
use common\models\recipe\RecipeItemInfo;
use yii\base\Action;
use Yii;
use yii\web\HttpException;

class ExpAction extends Action
{
    public function run($id)
    {
        $Recipe = Recipe::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        if(!$Recipe) {
            throw new HttpException(404, 'Рецепт не найден');
        }

        $item_id = Yii::$app->request->get('item_id', null);
        if($item_id) {
            $model = RecipeItemGive::findOne($item_id);
            if(!$model) {
                throw new HttpException(404, 'Задание не найдено');
            }

            $item = $model->info;
        } else {
            $model = new RecipeItemGive();
            $model->recipe_id = $Recipe->id;

            $item = new RecipeGiveExp();
        }

        $r2 = $item->load(Yii::$app->request->post());
        if ($r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    RecipeItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
                }

                $Profession = CraftProf::findOne($item->profession_id);
                if(!$Profession) {
                    throw new HttpException(404, 'Профессия не найдена');
                }
                $item->profession_name = $Profession->name;

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
                        'recipe_id'         => $model->recipe_id,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(RecipeItemInfo::tableName(), (new RecipeItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                return $this->controller->redirect(['/recipe/recipe/view', 'id' => $Recipe->id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->controller->render('exp', [
            'model' => $model,
            'item'  => $item,
            'recipe' => $Recipe,
        ]);
    }
}