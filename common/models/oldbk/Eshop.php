<?php

namespace common\models\oldbk;

use common\helper\ShopHelper;
use common\models\oldbk\shop\BaseShop;
use Yii;

/**
 * This is the model class for table "eshop".
 *
 * @property integer $id
 * @property string $name
 * @property integer $duration
 * @property integer $maxdur
 * @property double $cost
 * @property double $ecost
 * @property integer $count
 * @property integer $avacount
 * @property integer $angcount
 * @property integer $nlevel
 * @property integer $nsila
 * @property integer $nlovk
 * @property integer $ninta
 * @property integer $nvinos
 * @property integer $nintel
 * @property integer $nmudra
 * @property integer $nnoj
 * @property integer $ntopor
 * @property integer $ndubina
 * @property integer $nmech
 * @property integer $nalign
 * @property integer $minu
 * @property integer $maxu
 * @property integer $gsila
 * @property integer $glovk
 * @property integer $ginta
 * @property integer $gintel
 * @property integer $ghp
 * @property integer $gmp
 * @property integer $mfkrit
 * @property integer $mfakrit
 * @property integer $mfuvorot
 * @property integer $mfauvorot
 * @property integer $gnoj
 * @property integer $gtopor
 * @property integer $gdubina
 * @property integer $gmech
 * @property string $img
 * @property integer $shshop
 * @property integer $bron1
 * @property integer $bron2
 * @property integer $bron3
 * @property integer $bron4
 * @property integer $dategoden
 * @property integer $magic
 * @property integer $type
 * @property double $massa
 * @property integer $goden
 * @property integer $needident
 * @property integer $nfire
 * @property integer $nwater
 * @property integer $nair
 * @property integer $nearth
 * @property integer $nlight
 * @property integer $ngray
 * @property integer $ndark
 * @property integer $gfire
 * @property integer $gwater
 * @property integer $gair
 * @property integer $gearth
 * @property integer $glight
 * @property integer $ggray
 * @property integer $gdark
 * @property string $letter
 * @property integer $isrep
 * @property integer $razdel
 * @property integer $glava
 * @property integer $nsex
 * @property integer $owner
 * @property string $klan
 * @property integer $group
 * @property integer $gmeshok
 * @property integer $mfbonus
 * @property integer $includemagic
 * @property integer $includemagicdex
 * @property integer $includemagicmax
 * @property string $includemagicname
 * @property integer $includemagicuses
 * @property double $includemagiccost
 * @property double $includemagicekrcost
 * @property integer $ab_mf
 * @property integer $ab_bron
 * @property integer $ab_uron
 * @property integer $need_wins
 * @property integer $artproto
 * @property integer $wopen
 * @property integer $charge_rep
 * @property integer $is_owner
 * @property string $unikflag
 * @property integer $stbonus
 * @property string $ekr_flag
 * @property string $img_big
 *
 * @property DressroomItems $dressroomItem
 */
class Eshop extends BaseShop
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eshop';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['duration', 'maxdur', 'count', 'avacount', 'angcount', 'nlevel', 'nsila', 'nlovk', 'ninta', 'nvinos', 'nintel', 'nmudra', 'nnoj', 'ntopor', 'ndubina', 'nmech', 'nalign', 'minu', 'maxu', 'gsila', 'glovk', 'ginta', 'gintel', 'ghp', 'gmp', 'mfkrit', 'mfakrit', 'mfuvorot', 'mfauvorot', 'gnoj', 'gtopor', 'gdubina', 'gmech', 'shshop', 'bron1', 'bron2', 'bron3', 'bron4', 'dategoden', 'magic', 'type', 'goden', 'needident', 'nfire', 'nwater', 'nair', 'nearth', 'nlight', 'ngray', 'ndark', 'gfire', 'gwater', 'gair', 'gearth', 'glight', 'ggray', 'gdark', 'isrep', 'razdel', 'glava', 'nsex', 'owner', 'group', 'gmeshok', 'mfbonus', 'includemagic', 'includemagicdex', 'includemagicmax', 'includemagicuses', 'ab_mf', 'ab_bron', 'ab_uron', 'need_wins', 'artproto', 'wopen', 'charge_rep', 'is_owner', 'unikflag', 'stbonus', 'ekr_flag', 'dressroom'], 'integer'],
            [['cost', 'ecost', 'letter', 'includemagic', 'includemagicdex', 'includemagicmax', 'includemagicname', 'includemagicuses'], 'required'],
            [['cost', 'ecost', 'massa', 'includemagiccost', 'includemagicekrcost'], 'number'],
            [['letter'], 'string'],
            [['name', 'klan'], 'string', 'max' => 255],
            [['img', 'includemagicname', 'img_big'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'duration' => 'Duration',
            'maxdur' => 'Maxdur',
            'cost' => 'Cost',
            'ecost' => 'Ecost',
            'count' => 'Count',
            'avacount' => 'Avacount',
            'angcount' => 'Angcount',
            'nlevel' => 'Nlevel',
            'nsila' => 'Nsila',
            'nlovk' => 'Nlovk',
            'ninta' => 'Ninta',
            'nvinos' => 'Nvinos',
            'nintel' => 'Nintel',
            'nmudra' => 'Nmudra',
            'nnoj' => 'Nnoj',
            'ntopor' => 'Ntopor',
            'ndubina' => 'Ndubina',
            'nmech' => 'Nmech',
            'nalign' => 'Nalign',
            'minu' => 'Minu',
            'maxu' => 'Maxu',
            'gsila' => 'Gsila',
            'glovk' => 'Glovk',
            'ginta' => 'Ginta',
            'gintel' => 'Gintel',
            'ghp' => 'Ghp',
            'gmp' => 'Gmp',
            'mfkrit' => 'Mfkrit',
            'mfakrit' => 'Mfakrit',
            'mfuvorot' => 'Mfuvorot',
            'mfauvorot' => 'Mfauvorot',
            'gnoj' => 'Gnoj',
            'gtopor' => 'Gtopor',
            'gdubina' => 'Gdubina',
            'gmech' => 'Gmech',
            'img' => 'Img',
            'shshop' => 'Shshop',
            'bron1' => 'Bron1',
            'bron2' => 'Bron2',
            'bron3' => 'Bron3',
            'bron4' => 'Bron4',
            'dategoden' => 'Dategoden',
            'magic' => 'Magic',
            'type' => 'Type',
            'massa' => 'Massa',
            'goden' => 'Goden',
            'needident' => 'Needident',
            'nfire' => 'Nfire',
            'nwater' => 'Nwater',
            'nair' => 'Nair',
            'nearth' => 'Nearth',
            'nlight' => 'Nlight',
            'ngray' => 'Ngray',
            'ndark' => 'Ndark',
            'gfire' => 'Gfire',
            'gwater' => 'Gwater',
            'gair' => 'Gair',
            'gearth' => 'Gearth',
            'glight' => 'Glight',
            'ggray' => 'Ggray',
            'gdark' => 'Gdark',
            'letter' => 'Letter',
            'isrep' => 'Isrep',
            'razdel' => 'Razdel',
            'glava' => 'Glava',
            'nsex' => 'Nsex',
            'owner' => 'Owner',
            'klan' => 'Klan',
            'group' => 'Group',
            'gmeshok' => 'Gmeshok',
            'mfbonus' => 'Mfbonus',
            'includemagic' => 'Includemagic',
            'includemagicdex' => 'Includemagicdex',
            'includemagicmax' => 'Includemagicmax',
            'includemagicname' => 'Includemagicname',
            'includemagicuses' => 'Includemagicuses',
            'includemagiccost' => 'Includemagiccost',
            'includemagicekrcost' => 'Includemagicekrcost',
            'ab_mf' => 'Ab Mf',
            'ab_bron' => 'Ab Bron',
            'ab_uron' => 'Ab Uron',
            'need_wins' => 'Need Wins',
            'artproto' => 'Artproto',
            'wopen' => 'Wopen',
            'charge_rep' => 'Charge Rep',
            'is_owner' => 'Is Owner',
            'unikflag' => 'Unikflag',
            'stbonus' => 'Stbonus',
            'ekr_flag' => 'Ekr Flag',
            'img_big' => 'Img Big',
			'dressroom' => 'В примерочной',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\EshopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\EshopQuery(get_called_class());
    }

	public function getDressroomItem()
	{
		return $this->hasOne(DressroomItems::className(), ['item_id' => 'id'])
			->where('shop_id = :shop_id', [':shop_id' => ShopHelper::TYPE_ESHOP]);
	}
}
