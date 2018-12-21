<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 01.03.2016
 */

namespace common\helper;

use common\models\oldbk\Cshop;
use common\models\oldbk\Eshop;
use common\models\oldbk\search\CshopSearch;
use common\models\oldbk\search\EshopSearch;
use common\models\oldbk\search\ShopSearch;
use common\models\oldbk\Shop;

class ShopHelper
{
    const TYPE_SHOP         = 1;
    const TYPE_ESHOP        = 2;
    const TYPE_CSHOP        = 3;
    const TYPE_OWN_ABILITY  = 4;
    const TYPE_FSHOP        = 5;
    const TYPE_FAIRSHOP     = 6;


    private static $string_name = array(
        self::TYPE_SHOP     => 'shop',
        self::TYPE_ESHOP    => 'eshop',
        self::TYPE_CSHOP    => 'cshop',
    );

    public static function getSearchModelByShopId($shop_id)
    {
        switch ($shop_id) {
            case self::TYPE_SHOP:
                return new ShopSearch();
                break;
            case self::TYPE_ESHOP:
                return new ShopSearch();
                break;
            case self::TYPE_CSHOP:
                return new ShopSearch();
                break;
        }

        throw new \Exception('Shop search model not found');
    }

    public static function getShopList()
    {
        return [
            self::TYPE_SHOP     => 'Гос магазин',
            self::TYPE_ESHOP    => 'Березка',
            self::TYPE_CSHOP    => 'Храм лавка',
            self::TYPE_FSHOP    => 'Цветочка',
            self::TYPE_FAIRSHOP => 'Ярмарка',
        ];
    }

    public static function getShopListAbility()
    {
        $list = self::getShopList();
        $list[self::TYPE_OWN_ABILITY] = 'Личные реликты';

        return $list;
    }

    public static function getShopName($shop)
    {
        return self::getShopList()[$shop];
    }

    /**
     * @param $shop_id
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Exception
     */
    public static function searchByShopId($shop_id, $params)
    {
    	$searchParams = [];
        /** @var ShopSearch|CshopSearch|EshopSearch $obj */
        $obj = null;
        switch ($shop_id) {
            case self::TYPE_SHOP:
                $obj = new ShopSearch();
				$searchParams['ShopSearch'] = $params;
                break;
            case self::TYPE_CSHOP:
                $obj = new CshopSearch();
				$searchParams['CshopSearch'] = $params;
                break;
            case self::TYPE_ESHOP:
                $obj = new EshopSearch();
				$searchParams['EshopSearch'] = $params;
                break;
            default:
                throw new \Exception('Shop not found');
                break;
        }

        return $obj->search($searchParams);
    }

    public static function search($params)
    {
        foreach (array_keys(self::$string_name) as $shop_id) {
            $dataProvider = self::searchByShopId($shop_id, $params);
            if($dataProvider->totalCount > 0) {
                return $dataProvider;
            }
        }

        return false;
    }

    public static function getItemByShopId($shop_id, $params)
    {
        /** @var Shop|Eshop|Cshop $obj */
        $obj = null;
        switch ($shop_id) {
            case self::TYPE_SHOP:
                $obj = new Shop();
                break;
            case self::TYPE_CSHOP:
                $obj = new Cshop();
                break;
            case self::TYPE_ESHOP:
                $obj = new Eshop();
                break;
            default:
                throw new \Exception('Shop not found');
                break;
        }

        return $obj->findOne($params);
    }

    public static function getItem($params)
    {
        foreach (array_keys(self::$string_name) as $shop_id) {
            $Item = self::getItemByShopId($shop_id, $params);
            if($Item) {
                return $Item;
            }
        }

        return false;
    }

}