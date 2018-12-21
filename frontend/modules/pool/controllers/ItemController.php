<?php

namespace frontend\modules\pool\controllers;

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
use common\models\oldbk\Shop;
use common\models\pool\PoolPocket;
use common\models\pool\PoolPocketItem;
use common\models\pool\PoolPocketItemInfo;
use common\models\pool\PoolValidator;
use common\models\pool\PoolValidatorInfo;
use common\models\QuestMedal;
use Yii;
use frontend\components\AuthController;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * Class ManagerController
 * @package frontend\modules\pool\controllers
 */
class ItemController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	/**
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionItem($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}

		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new ItemInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}


		$r1 = $model->load(Yii::$app->request->post());
		$r2 = $item->load(Yii::$app->request->post());
		if ($r1 && $r2 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
				}

				/** @var Shop|Eshop|Cshop $OldbkItem */
				$OldbkItem = ShopHelper::getItemByShopId($item->shop_id, ['id' => $item->item_id]);
				if(!$OldbkItem) {
					throw new HttpException('Предмет не найден');
				}

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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
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
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionRepa($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}

		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new RepaInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		if ($r1 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
			} catch (\Exception $ex) {
				$t->rollBack();
			}
		}

		return $this->render('repa/create', [
			'model' => $model,
			'pocket' => $Pocket,
		]);
	}

	/**
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionExp($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}
		
		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new ExpInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		if ($r1 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
			} catch (\Exception $ex) {
				$t->rollBack();
			}
		}

		return $this->render('exp/create', [
			'model' => $model,
			'pocket' => $Pocket,
		]);
	}

	/**
	 * @param $id
	 * @param $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionKr($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}
		
		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new KrInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		if ($r1 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
			} catch (\Exception $ex) {
				$t->rollBack();
			}
		}

		return $this->render('kr/create', [
			'model' => $model,
			'pocket' => $Pocket,
		]);
	}

	/**
	 * @param $id
	 * @param $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionWeight($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->andWhere('id = :id', [':id' => $id])
			->with('pool')
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}
		
		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new WeightInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		$item->load(Yii::$app->request->post());
		if ($r1 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
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
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionEkr($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}
		
		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new EkrInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		if ($r1 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
			} catch (\Exception $ex) {
				$t->rollBack();
			}
		}

		return $this->render('ekr/create', [
			'model' => $model,
			'pocket' => $Pocket,
		]);
	}

	/**
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionAbility($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}

		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new AbilityInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		$r2 = $item->load(Yii::$app->request->post());

		if ($r1 && $r2 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
				}

				/** @var AbilityOwn $Ability */
				$Ability = AbilityOwn::findOne($item->magic_id);
				if(!$Ability) {
					throw new HttpException('Абилити не найдено');
				}

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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
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

	/**
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionMedal($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}

		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new MedalInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r2 = $item->load(Yii::$app->request->post());
		if ($r2 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
				}

				$Medal = QuestMedal::findOne($item->medal_id);
				if(!$Medal) {
					throw new HttpException(404, 'Медаль не найдена');
				}

				$model->give_count = 1;
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
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
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

	/**
	 * @param $id
	 * @param null $item_id
	 * @return string|\yii\web\Response
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionProfexp($id, $item_id = null)
	{
		$Pocket = PoolPocket::find()
			->with('pool')
			->andWhere('id = :id', [':id' => $id])
			->one();
		if(!$Pocket) {
			throw new HttpException(404, 'Список не найден');
		}

		if($item_id) {
			$model = PoolPocketItem::findOne($item_id);
			if(!$model) {
				throw new HttpException(404, 'Награда не найдена');
			}

			$item = $model->info;
		} else {
			$item = new ProfExpInfo();

			$model = new PoolPocketItem();
			$model->pocket_id = $Pocket->id;
			$model->pool_id = $Pocket->pool_id;
			$model->item_type = $item->getItemType();
		}

		$r1 = $model->load(Yii::$app->request->post());
		$item->load(Yii::$app->request->post());
		if ($r1 && $item->validate()) {
			$t = Yii::$app->db->beginTransaction();
			try {
				if(!$model->isNewRecord) {
					PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);
				}

				$Profession = CraftProf::findOne($item->profession_id);
				if(!$Profession) {
					throw new \Exception();
				}

				$item->profession_name = $Profession->rname;
				if(!$model->save()) {
					throw new \Exception();
				}

				$rows = [];
				foreach ($item->getAttributes() as $field => $value) {
					if(!$value) {
						continue;
					}
					$rows[] = [
						'pocket_item_id'    => $model->id,
						'field'             => $field,
						'value'             => $value,
						'pool_id'    		=> $model->pool_id,
						'pocket_id'         => $model->pocket_id,
					];
				}

				if($rows) {
					Yii::$app->db->createCommand()
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				return $this->redirect(['/pool/manager/view', 'id' => $Pocket->pool_id]);
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

	/**
	 * @param $id
	 * @return string
	 * @throws \yii\db\Exception
	 */
	public function actionUpdate($id)
	{
		$model = PoolPocketItem::find()
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

				PoolPocketItemInfo::deleteAll('item_id = :item_id', [':item_id' => $model->id]);

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
						->batchInsert(PoolPocketItemInfo::tableName(), (new PoolPocketItemInfo)->attributes(), $rows)->execute();
				}

				$t->commit();

				$model = PoolPocketItem::find()
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
	 * @param $id
	 * @return bool|\yii\web\Response
	 * @throws \Throwable
	 * @throws \yii\db\Exception
	 */
	public function actionDelete($id)
	{
		$t = Yii::$app->db->beginTransaction();
		$model = PoolPocketItem::find()
			->andWhere('id = :id', [':id' => $id])
			->one();

		if(!$model) {
			return false;
		}

		try {
			PoolPocketItemInfo::deleteAll('pocket_item_id = :pocket_item_id', [':pocket_item_id' => $model->id]);

			PoolValidatorInfo::deleteAll('target_type = :target_type and target_id = :target_id',
				[
					':target_type' => PoolValidator::TARGET_POCKET_ITEM,
					':target_id' => $model->id
				]);
			PoolValidator::deleteAll('target_type = :target_type and target_id = :target_id',
				[
					':target_type' => PoolValidator::TARGET_POCKET_ITEM,
					':target_id' => $model->id
				]);

			$model->delete();

			$t->commit();
		} catch (\Exception $ex) {
			$t->rollBack();
		}

		return $this->redirect(['/pool/manager/view', 'id' => $model->pool_id]);
	}
}
