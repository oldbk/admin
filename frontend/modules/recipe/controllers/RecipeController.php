<?php

namespace frontend\modules\recipe\controllers;

use common\helper\ShopHelper;
use common\models\Notepad;
use common\models\oldbk\CraftFormula;
use common\models\oldbk\CraftProf;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\Shop;
use common\models\recipe\BaseRecipeGive;
use common\models\recipe\BaseRecipeNeed;
use common\models\recipe\give\RecipeGiveExp;
use common\models\recipe\give\RecipeGiveItem;
use common\models\recipe\need\RecipeNeedAlign;
use common\models\recipe\need\RecipeNeedIngredient;
use common\models\recipe\need\RecipeNeedProfession;
use common\models\recipe\need\RecipeNeedStat;
use common\models\recipe\need\RecipeNeedUserLevel;
use common\models\recipe\need\RecipeNeedVlad;
use common\models\recipe\Recipe;
use common\models\recipe\RecipeItem;
use common\models\recipe\RecipeItemInfo;
use common\models\search\RecipeSearch;
use frontend\components\AuthController;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestController implements the CRUD actions for QuestList model.
 */
class RecipeController extends AuthController
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
                'delete' => ['POST','GET'],
            ],
        ];
        return $parent;
    }

    /**
     * Lists all Quest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecipeSearch(['scenario' => Recipe::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->with(['razdel', 'profession', 'location']);

        $Notepad = Notepad::find()
            ->andWhere('place = :place', [':place' => Notepad::PLACE_RECIPE])
            ->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'notepad' => $Notepad,
        ]);
    }

    /**
     * Displays a single QuestList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $Recipe = $this->findModel($id);

        $itemNeedProvider = new ArrayDataProvider([
            'allModels' => $Recipe->recipeItemNeed,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        $itemGiveProvider = new ArrayDataProvider([
            'allModels' => $Recipe->recipeItemGive,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('view', [
            'model' => $Recipe,
            'itemNeedProvider' => $itemNeedProvider,
            'itemGiveProvider' => $itemGiveProvider,
        ]);
    }

    /**
     * Creates a new QuestList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Recipe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCalc($id)
    {
        $Recipe = $this->findModel($id);

        $cost_need = 0;
        $cost_profit = 0;
        foreach ($Recipe->recipeItemNeed as $_item) {
            if($_item->item_type != BaseRecipeNeed::TYPE_INGREDIENT) {
                continue;
            }

            /** @var Shop|Eshop|Cshop $OldbkItem */
            $OldbkItem = ShopHelper::getItemByShopId($_item->info->shop_id, ['id' => $_item->info->item_id]);
            if(!$OldbkItem) {
                throw new HttpException('Предмет не найден');
            }

            $cost_need += $OldbkItem->cost * $_item->info->count;
        }
        foreach ($Recipe->recipeItemGive as $_item) {
            if($_item->item_type != BaseRecipeGive::TYPE_ITEM) {
                continue;
            }

            /** @var Shop|Eshop|Cshop $OldbkItem */
            $OldbkItem = ShopHelper::getItemByShopId($_item->info->shop_id, ['id' => $_item->info->item_id]);
            if(!$OldbkItem) {
                throw new HttpException('Предмет не найден');
            }

            $cost_profit += $OldbkItem->cost * $_item->info->count;
        }

        $Recipe->cost_need = $cost_need;
        $Recipe->cost_profit = $cost_profit;
        $Recipe->save();

        return $this->redirect(Yii::$app->request->getReferrer());
    }


    /**
     * Updates an existing QuestList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing QuestList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $t = Yii::$app->db->beginTransaction();
        $model = $this->findModel($id);
        try {
            $model->is_deleted = true;
            $model->save();


            $RecipeGame = CraftFormula::findOne($model->id);
            if($RecipeGame) {
                $RecipeGame->is_deleted = 1;
                $RecipeGame->save();
            }

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/recipe/recipe/index']);
    }

    public function actionClone($id)
    {
        $t = Yii::$app->db->beginTransaction();
        try {
            $Recipe = $this->findModel($id);

            $RecipeCopy = new Recipe();
            $RecipeCopy->name = 'Копия '.$Recipe->name;
            $RecipeCopy->time = $Recipe->time;
            $RecipeCopy->category_id = $Recipe->category_id;
            $RecipeCopy->profession_id = $Recipe->profession_id;
            $RecipeCopy->location_id = $Recipe->location_id;
            $RecipeCopy->difficult = $Recipe->difficult;
            $RecipeCopy->craftmfchance = $Recipe->craftmfchance;
            $RecipeCopy->goden = $Recipe->goden;
            $RecipeCopy->notsell = $Recipe->notsell;
            $RecipeCopy->sowner = $Recipe->sowner;
            $RecipeCopy->present = $Recipe->present;
            $RecipeCopy->is_present = $Recipe->is_present;
            $RecipeCopy->unik = $Recipe->unik;
            $RecipeCopy->naem = $Recipe->naem;

            if(!$RecipeCopy->save()) {
                throw new \Exception();
            }

            $Items = RecipeItem::findAll(['recipe_id' => $Recipe->id]);
            foreach ($Items as $_item) {
                $ItemCopy                   = new RecipeItem();
                $ItemCopy->recipe_id        = $RecipeCopy->id;
                $ItemCopy->item_type        = $_item->item_type;
                $ItemCopy->operation_type   = $_item->operation_type;
                if(!$ItemCopy->save()) {
                    throw new \Exception();
                }

                $rows = [];
                foreach ($_item->info->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'item_id'           => $ItemCopy->id,
                        'field'             => $field,
                        'value'             => $value,
                        'recipe_id'         => $ItemCopy->recipe_id,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(RecipeItemInfo::tableName(), (new RecipeItemInfo)->attributes(), $rows)->execute();
                }
            }

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['index']);
    }

    public function actionExport($id)
    {
        $t = CraftFormula::getDb()->beginTransaction();
        try {
            $Recipe = $this->findModel($id);

            if($this->export($Recipe) === false) {
                throw new \Exception();
            }

            $t->commit();

            return Json::encode([
                'success' => true,
                'messages' => [
                    ['title' => 'Операция завершена', 'text' => 'Успешно экспортировали рецепт']
                ],
            ]);
        } catch (\Exception $ex) {
            $t->rollBack();

            return Json::encode([
                'error' => true,
                'messages' => [
                    [
                        'title' => 'Операция завершена с ошибкой',
                        'text' => $ex->getMessage(),
                        'debug' => $ex->getLine(),
                        'trace' => $ex->getTraceAsString()
                    ]
                ]
            ]);
        }
    }

    public function actionAll()
    {
        $RecipeList = Recipe::find()
            ->andWhere('is_deleted = 0')
            ->all();
        foreach ($RecipeList as $Recipe) {
            $t = CraftFormula::getDb()->beginTransaction();
            try {
                if($this->export($Recipe) === false) {
                    throw new \Exception();
                }

                $t->commit();

            } catch (\Exception $ex) {
                $t->rollBack();

                return Json::encode([
                    'error' => true,
                    'messages' => [
                        [
                            'title' => 'Операция завершена с ошибкой',
                            'text' => $ex->getMessage(),
                            'debug' => $ex->getLine(),
                        ]
                    ]
                ]);
            }
        }

        return Json::encode([
            'success' => true,
            'messages' => [
                ['title' => 'Операция завершена', 'text' => 'Успешно экспортировали рецепты']
            ],
        ]);
    }

    /**
     * @param Recipe $Recipe
     * @throws \Exception
     */
    private function export($Recipe)
    {
        $_craftProf = [];
        foreach (CraftProf::find()->all() as $prof) {
            $_craftProf[$prof->id] = $prof->name;
        }

        $RecipeGame = CraftFormula::findOne($Recipe->id);
        if(!$RecipeGame) {
            $RecipeGame = new CraftFormula();
            $RecipeGame->craftid = $Recipe->id;
        }
        $RecipeGame->craftnprofhunter = 0;
        $RecipeGame->craftnprofwoodman = 0;
        $RecipeGame->craftnprofminer = 0;
        $RecipeGame->craftnproffarmer = 0;
        $RecipeGame->craftnprofherbalist = 0;
        $RecipeGame->craftnprofcook = 0;
        $RecipeGame->craftnprofsmith = 0;
        $RecipeGame->craftnprofarmorer = 0;
        $RecipeGame->craftnprofarmorsmith = 0;
        $RecipeGame->craftnproftailor = 0;
        $RecipeGame->craftnprofjeweler = 0;
        $RecipeGame->craftnprofalchemist = 0;
        $RecipeGame->craftnprofmage = 0;
        $RecipeGame->craftnprofcarpenter = 0;
        $RecipeGame->craftnprofprospector = 0;
        $RecipeGame->craftnalign = "";

        $RecipeGame->craftnsila     = 0;
        $RecipeGame->craftnlovk     = 0;
        $RecipeGame->craftninta     = 0;
        $RecipeGame->craftnvinos    = 0;
        $RecipeGame->craftnintel    = 0;
        $RecipeGame->craftnmudra    = 0;

        $RecipeGame->craftnnoj      = 0;
        $RecipeGame->craftntopor    = 0;
        $RecipeGame->craftndubina   = 0;
        $RecipeGame->craftnmech     = 0;
        $RecipeGame->craftnfire     = 0;
        $RecipeGame->craftnwater    = 0;
        $RecipeGame->craftnair      = 0;
        $RecipeGame->craftnearth    = 0;
        $RecipeGame->craftnlight    = 0;
        $RecipeGame->craftngray     = 0;
        $RecipeGame->craftndark  	= 0;

        $RecipeGame->craftprotocount    = 0;
        $RecipeGame->craftprototype     = 0;
        $RecipeGame->craftprotoid       = 0;

        $RecipeGame->craftgetprof   = 0;
        $RecipeGame->craftgetexp    = 0;

        $RecipeGame->craftnotsell = 0;
        $RecipeGame->craftsowner = 0;
        $RecipeGame->craftgoden = 0;
        $RecipeGame->craftis_present = 0;
        $RecipeGame->craftpresent = "";
        $RecipeGame->craftunik = 0;
        $RecipeGame->craftnaem = 0;


        $_ingredient = [];
        $_need_profs = [];
        foreach ($Recipe->recipeItemNeed as $item) {
            switch ($item->item_type) {
                case BaseRecipeNeed::TYPE_ALIGN:
                    /** @var RecipeNeedAlign $Align */
                    $Align = $item->info;
                    $RecipeGame->craftnalign = $Align->aligns;
                    break;
                case BaseRecipeNeed::TYPE_PROFESSION:
                    /** @var RecipeNeedProfession $Profession */
                    $Profession = $item->info;

                    if(isset($_craftProf[$Profession->profession_id])) {
                        $name = sprintf('craftnprof%s', $_craftProf[$Profession->profession_id]);
                        if($RecipeGame->hasAttribute($name)) {
                            $RecipeGame->{$name} = $Profession->level;
                        }
                    }

                    break;
                case BaseRecipeNeed::TYPE_INGREDIENT:
                    /** @var RecipeNeedIngredient $Ingredient */
                    $Ingredient = $item->info;
                    $_ingredient[$Ingredient->item_id] = $Ingredient->count;

                    break;
                case BaseRecipeNeed::TYPE_USER_LEVEL:
                    /** @var RecipeNeedUserLevel $UserLevel */
                    $UserLevel = $item->info;
                    $RecipeGame->craftnlevel = $UserLevel->level;
                    break;
                case BaseRecipeNeed::TYPE_STAT:
                    /** @var RecipeNeedStat $Stat */
                    $Stat = $item->info;
                    $RecipeGame->craftnsila     = $Stat->sila;
                    $RecipeGame->craftnlovk     = $Stat->lovk;
                    $RecipeGame->craftninta     = $Stat->inta;
                    $RecipeGame->craftnvinos    = $Stat->vinos;
                    $RecipeGame->craftnintel    = $Stat->intel;
                    $RecipeGame->craftnmudra    = $Stat->mudra;
                    break;
                case BaseRecipeNeed::TYPE_VLAD:
                    /** @var RecipeNeedVlad $Vlad */
                    $Vlad = $item->info;
                    $RecipeGame->craftnnoj      = $Vlad->noj;
                    $RecipeGame->craftntopor    = $Vlad->topor;
                    $RecipeGame->craftndubina   = $Vlad->dubina;
                    $RecipeGame->craftnmech     = $Vlad->mech;
                    $RecipeGame->craftnfire     = $Vlad->fire;
                    $RecipeGame->craftnwater    = $Vlad->water;
                    $RecipeGame->craftnair      = $Vlad->air;
                    $RecipeGame->craftnearth    = $Vlad->earth;
                    $RecipeGame->craftnlight    = $Vlad->light;
                    $RecipeGame->craftngray     = $Vlad->gray;
                    $RecipeGame->craftndark  	= $Vlad->dark;
                    break;
            }
        }

        foreach ($Recipe->recipeItemGive as $item) {
            switch ($item->item_type) {
                case BaseRecipeGive::TYPE_ITEM:
                    /** @var RecipeGiveItem $Item */
                    $Item = $item->info;
                    $RecipeGame->craftprotocount    = $Item->count;
                    $RecipeGame->craftprototype     = $Item->shop_id;
                    $RecipeGame->craftprotoid       = $Item->item_id;
                    break;
                case BaseRecipeGive::TYPE_EXP:
                    /** @var RecipeGiveExp $Exp */
                    $Exp = $item->info;
                    $RecipeGame->craftgetprof   = $Exp->profession_id;
                    $RecipeGame->craftgetexp    = $Exp->count;
                    break;
            }
        }

        $RecipeGame->craftcomplexity    = $Recipe->difficult;
        $RecipeGame->craftrazdel        = $Recipe->razdel->razdel;
        $RecipeGame->craftloc           = $Recipe->location_id;
        $RecipeGame->craftnres          = serialize($_ingredient);
        //$RecipeGame->craftnprof         = serialize($_need_profs);
        $RecipeGame->crafttime          = $Recipe->time;
        $RecipeGame->is_enabled         = $Recipe->is_enabled;
        $RecipeGame->is_vaza         	= $Recipe->is_vaza;
        $RecipeGame->is_deleted         = $Recipe->is_deleted;
        $RecipeGame->craftmfchance      = $Recipe->craftmfchance;

        $RecipeGame->craftnotsell      	= $Recipe->notsell;
        $RecipeGame->craftsowner      	= $Recipe->sowner;
        $RecipeGame->craftis_present    = $Recipe->is_present;
        $RecipeGame->craftgoden      	= $Recipe->goden;
        $RecipeGame->craftpresent      	= $Recipe->present;
        $RecipeGame->craftunik      	= $Recipe->unik;
        $RecipeGame->craftnaem      	= $Recipe->naem;

        if(!$RecipeGame->save()) {
            return false;
        }

        return true;
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
