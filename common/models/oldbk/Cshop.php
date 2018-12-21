<?php

namespace common\models\oldbk;

use common\helper\ShopHelper;
use common\models\oldbk\shop\BaseShop;
use Yii;

/**
 * This is the model class for table "{{%cshop}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $duration
 * @property integer $maxdur
 * @property double $cost
 * @property double $ecost
 * @property integer $repcost
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
 * @property integer $gmeshok
 * @property integer $charge_rep
 * @property integer $group
 * @property integer $is_owner
 * @property integer $mfbonus
 * @property integer $ab_mf
 * @property integer $ab_bron
 * @property integer $ab_uron
 * @property integer $artproto
 * @property integer $glava
 * @property integer $includemagic
 * @property double $includemagiccost
 * @property integer $includemagicdex
 * @property double $includemagicekrcost
 * @property integer $includemagicmax
 * @property string $includemagicname
 * @property integer $includemagicuses
 * @property string $klan
 * @property integer $need_wins
 * @property integer $nsex
 * @property integer $owner
 * @property integer $wopen
 * @property string $unikflag
 * @property string $stbonus
 * @property string $ekr_flag
 * @property string $img_big
 *
 * @property DressroomItems $dressroomItem
 */
class Cshop extends BaseShop
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cshop}}';
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
            [['duration', 'maxdur', 'repcost', 'count', 'avacount', 'angcount', 'nlevel', 'nsila', 'nlovk', 'ninta', 'nvinos', 'nintel', 'nmudra', 'nnoj', 'ntopor', 'ndubina', 'nmech', 'nalign', 'minu', 'maxu', 'gsila', 'glovk', 'ginta', 'gintel', 'ghp', 'gmp', 'mfkrit', 'mfakrit', 'mfuvorot', 'mfauvorot', 'gnoj', 'gtopor', 'gdubina', 'gmech', 'shshop', 'bron1', 'bron2', 'bron3', 'bron4', 'dategoden', 'magic', 'type', 'goden', 'needident', 'nfire', 'nwater', 'nair', 'nearth', 'nlight', 'ngray', 'ndark', 'gfire', 'gwater', 'gair', 'gearth', 'glight', 'ggray', 'gdark', 'isrep', 'razdel', 'gmeshok', 'charge_rep', 'group', 'is_owner', 'mfbonus', 'ab_mf', 'ab_bron', 'ab_uron', 'artproto', 'glava', 'includemagic', 'includemagicdex', 'includemagicmax', 'includemagicuses', 'need_wins', 'nsex', 'owner', 'wopen', 'unikflag', 'stbonus', 'ekr_flag', 'dressroom'], 'integer'],
            [['cost', 'ecost', 'massa', 'includemagiccost', 'includemagicekrcost'], 'number'],
            [['gmp', 'letter', 'gmeshok', 'includemagic', 'includemagicdex', 'includemagicmax', 'includemagicname', 'includemagicuses'], 'required'],
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
            'repcost' => 'Repcost',
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
            'gmeshok' => 'Gmeshok',
            'charge_rep' => 'Charge Rep',
            'group' => 'Group',
            'is_owner' => 'Is Owner',
            'mfbonus' => 'Mfbonus',
            'ab_mf' => 'Ab Mf',
            'ab_bron' => 'Ab Bron',
            'ab_uron' => 'Ab Uron',
            'artproto' => 'Artproto',
            'glava' => 'Glava',
            'includemagic' => 'Includemagic',
            'includemagiccost' => 'Includemagiccost',
            'includemagicdex' => 'Includemagicdex',
            'includemagicekrcost' => 'Includemagicekrcost',
            'includemagicmax' => 'Includemagicmax',
            'includemagicname' => 'Includemagicname',
            'includemagicuses' => 'Includemagicuses',
            'klan' => 'Klan',
            'need_wins' => 'Need Wins',
            'nsex' => 'Nsex',
            'owner' => 'Owner',
            'wopen' => 'Wopen',
            'unikflag' => 'Unikflag',
            'stbonus' => 'Stbonus',
            'ekr_flag' => 'Ekr Flag',
            'img_big' => 'Img Big',
            'dressroom' => 'В примерочной',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CshopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CshopQuery(get_called_class());
    }

	public function getDressroomItem()
	{
		return $this->hasOne(DressroomItems::className(), ['item_id' => 'id'])
			->where('shop_id = :shop_id', [':shop_id' => ShopHelper::TYPE_CSHOP]);
	}
}
