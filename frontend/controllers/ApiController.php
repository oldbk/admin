<?php
namespace frontend\controllers;

use common\models\itemInfo\BaseInfo;
use common\models\itemInfo\ItemInfo;
use common\models\loto\LotoItem;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class ApiController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionGiftBox($id)
    {
        $Items = LotoItem::find()
            ->with('lotoItemInfos')
            ->andWhere('pocket_id = :pocket_id', [':pocket_id' => $id])
            ->all();

        $response = [];
        foreach ($Items as $Item) {
            if($Item->info->getItemType() !== BaseInfo::ITEM_TYPE_ITEM) {
                continue;
            }

            /** @var ItemInfo $ItemInfo */
            $ItemInfo = $Item->info;
            $response[] = [
                'prototype' 	=> $ItemInfo->item_id,
                'shop_id' 		=> $ItemInfo->shop_id,
                'count' 		=> $Item->count,
                'item_count' 	=> $Item->item_count,
				'ekrprice' 		=> $Item->cost,
            ];
        }

        return Json::encode($response);
    }
}
