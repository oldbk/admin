<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.06.2016
 */

namespace frontend\modules\recipe\controllers\actions\need;

use common\models\recipe\need\RecipeNeedStat;
use common\models\recipe\Recipe;
use common\models\recipe\RecipeItemInfo;
use common\models\recipe\RecipeItemNeed;
use yii\base\Action;
use Yii;
use yii\web\HttpException;

class StatAction extends Action
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
            $model = RecipeItemNeed::findOne($item_id);
            if(!$model) {
                throw new HttpException(404, 'Задание не найдено');
            }

            $item = $model->info;
        } else {
            $model = new RecipeItemNeed();
            $model->recipe_id = $Recipe->id;

            $item = new RecipeNeedStat();
        }

        $r2 = $item->load(Yii::$app->request->post());
        if ($r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    RecipeItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
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

        return $this->controller->render('stat', [
            'model' => $model,
            'item'  => $item,
            'recipe' => $Recipe,
        ]);
    }
}