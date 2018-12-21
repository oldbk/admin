<?php

namespace frontend\modules\quest\controllers;

use common\helper\ShopHelper;
use common\models\AbilityOwn;
use common\models\itemInfo\AbilityInfo;
use common\models\itemInfo\EkrInfo;
use common\models\itemInfo\ExpInfo;
use common\models\itemInfo\ItemInfo;
use common\models\itemInfo\KrInfo;
use common\models\itemInfo\MedalInfo;
use common\models\itemInfo\ProfExpInfo;
use common\models\itemInfo\RepaInfo;
use common\models\itemInfo\WeightInfo;
use common\models\oldbk\CraftProf;
use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\QuestValidatorItem;
use common\models\oldbk\QuestValidatorItemInfo;
use common\models\oldbk\Shop;
use common\models\QuestMedal;
use common\models\questPocket\QuestPocket;
use common\models\questPocket\QuestPocketPartReward;
use common\models\QuestPocketItem;
use common\models\QuestPocketItemInfo;
use frontend\components\AuthController;
use Yii;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for QuestPart model.
 */
class PartRewardController extends AuthController
{
    /**
     * @param $id //PocketID
     */
    public function actionItem($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new ItemInfo();
        }


        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());
        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
                }

                /** @var Shop|Eshop|Cshop $OldbkItem */
                $OldbkItem = ShopHelper::getItemByShopId($item->shop_id, ['id' => $item->item_id]);
                if(!$OldbkItem) {
                    throw new HttpException('Предмет не найден');
                }

                $model->item_type = $item->getItemType();
                if(!$model->save()) {
                    throw new \Exception();
                }

                $item->name = $OldbkItem->name;
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('item/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionRepa($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new RepaInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        if ($r1 && $item->validate()) {
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('repa/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionExp($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new ExpInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        if ($r1 && $item->validate()) {
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('exp/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionKr($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new KrInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        if ($r1 && $item->validate()) {
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('kr/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionWeight($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new WeightInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        $item->load(Yii::$app->request->post());
        if ($r1 && $item->validate()) {
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('weight/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionEkr($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new EkrInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        if ($r1 && $item->validate()) {
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('ekr/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionAbility($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new AbilityInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        $r2 = $item->load(Yii::$app->request->post());

        if ($r1 && $r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
                }

                /** @var AbilityOwn $Ability */
                $Ability = AbilityOwn::findOne($item->magic_id);
                if(!$Ability) {
                    throw new HttpException('Абилити не найдено');
                }

                $model->item_type = $item->getItemType();
                if(!$model->save()) {
                    throw new \Exception();
                }

                $item->name = $Ability->name;
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('ability/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    public function actionMedal($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new MedalInfo();
        }

        $r2 = $item->load(Yii::$app->request->post());
        if ($r2 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
                }

                $Medal = QuestMedal::findOne($item->medal_id);
                if(!$Medal) {
                    throw new HttpException(404, 'Медаль не найдена');
                }

                $model->count = 1;
                $model->item_type = $item->getItemType();
                if(!$model->save()) {
                    throw new \Exception();
                }

                $rows = [];
                $item->day = $Medal->day_count;
                $item->medal_key = $Medal->key;
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
                var_dump($ex->getMessage());die;
            }
        }

        return $this->render('medal/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = QuestPocketItem::find()
            ->andWhere('id = :id', [':id' => $id])
            ->one();
        $item = $model->info;

        $r1 = $model->load(Yii::$app->request->post());
        $item->load(Yii::$app->request->post());

        $success = false;
        if($r1) {
            $t = Yii::$app->db->beginTransaction();
            try {

                if(!$model->save()) {
                    throw new \Exception();
                }

                QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

                $rows = [];
                foreach ($item->getAttributes() as $field => $value) {
                    if(!$value) {
                        continue;
                    }
                    $rows[] = [
                        'pocket_id' => $model->pocket_id,
                        'item_id'   => $model->id,
                        'field'     => $field,
                        'value'     => $value,
                    ];
                }

                if($rows) {
                    Yii::$app->db->createCommand()
                        ->batchInsert(QuestPocketItemInfo::tableName(), (new QuestPocketItemInfo)->attributes(), $rows)->execute();
                }

                $t->commit();

                $model = QuestPocketItem::find()
                    ->andWhere('id = :id', [':id' => $id])
                    ->one();
                $item = $model->info;

                $success = true;
            } catch (\Exception $ex) {
                $t->rollBack();
                var_dump($ex->getMessage());die;
            }
        }

        return $this->render($item->getItemType().'/update', [
            'model' => $model,
            'item'  => $item,
            'success' => $success
        ]);
    }

    /**
     * @param $id //PocketID
     */
    public function actionProfexp($id)
    {
        $Pocket = QuestPocketPartReward::find()
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
                throw new HttpException(404, 'Награда не найдена');
            }

            $item = $model->info;
        } else {
            $model = new QuestPocketItem();
            $model->pocket_id = $Pocket->id;
            $model->pocket_item_id = $Pocket->item_id;
            $model->pocket_item_type = $Pocket->item_type;

            $item = new ProfExpInfo();
        }

        $r1 = $model->load(Yii::$app->request->post());
        $item->load(Yii::$app->request->post());
        if ($r1 && $item->validate()) {
            $t = Yii::$app->db->beginTransaction();
            try {
                if(!$model->isNewRecord) {
                    QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);
                }

                $Profession = CraftProf::findOne($item->profession_id);
                if(!$Profession) {
                    throw new \Exception();
                }

                $item->profession_name = $Profession->rname;
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

                return $this->redirect(['/quest/part/view', 'id' => $Pocket->item_id]);
            } catch (\Exception $ex) {
                $t->rollBack();
            }
        }

        return $this->render('profExp/create', [
            'model' => $model,
            'item'  => $item,
            'pocket' => $Pocket,
        ]);
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
        $part_id = $model->pocket_item_id;

        try {
        	QuestValidatorItemInfo::deleteAll('validator_parent_id = :id and validator_parent_type = "reward"', [
        		':id' => $model->id,
			]);
        	QuestValidatorItem::deleteAll('parent_id = :id and parent_type = "reward"', [
				':id' => $model->id,
			]);
            QuestPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

            $model->delete();

            $t->commit();
        } catch (\Exception $ex) {
            $t->rollBack();
        }

        return $this->redirect(['/quest/part/view', 'id' => $part_id]);
    }
}
