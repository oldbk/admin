<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $login
 * @property string $email
 * @property resource $pass
 * @property string $second_password
 * @property string $realname
 * @property string $borndate
 * @property integer $sex
 * @property string $city
 * @property integer $icq
 * @property string $http
 * @property string $info
 * @property string $lozung
 * @property string $color
 * @property integer $level
 * @property string $align
 * @property string $klan
 * @property integer $sila
 * @property integer $lovk
 * @property integer $inta
 * @property integer $vinos
 * @property integer $intel
 * @property integer $mudra
 * @property integer $duh
 * @property integer $bojes
 * @property string $money
 * @property integer $noj
 * @property integer $mec
 * @property integer $topor
 * @property integer $dubina
 * @property integer $win
 * @property integer $lose
 * @property string $status
 * @property string $borncity
 * @property string $borntime
 * @property integer $room
 * @property integer $maxhp
 * @property integer $hp
 * @property integer $maxmana
 * @property integer $mana
 * @property integer $sergi
 * @property integer $kulon
 * @property integer $perchi
 * @property integer $weap
 * @property integer $bron
 * @property integer $r1
 * @property integer $r2
 * @property integer $r3
 * @property integer $helm
 * @property integer $shit
 * @property integer $boots
 * @property integer $stats
 * @property string $exp
 * @property integer $master
 * @property string $shadow
 * @property string $nextup
 * @property integer $m1
 * @property integer $m2
 * @property integer $m3
 * @property integer $m4
 * @property integer $m5
 * @property integer $m6
 * @property integer $m7
 * @property integer $m8
 * @property integer $m9
 * @property integer $m10
 * @property integer $m11
 * @property integer $m12
 * @property integer $m13
 * @property integer $m14
 * @property integer $m15
 * @property string $nakidka
 * @property integer $mfire
 * @property integer $mwater
 * @property integer $mair
 * @property integer $mearth
 * @property integer $mlight
 * @property integer $mgray
 * @property integer $mdark
 * @property integer $fullhptime
 * @property integer $zayavka
 * @property integer $battle
 * @property integer $battle_t
 * @property integer $block
 * @property string $palcom
 * @property string $medals
 * @property string $ip
 * @property integer $podarokAD
 * @property integer $lab
 * @property integer $bot
 * @property integer $in_tower
 * @property string $ekr
 * @property integer $chattime
 * @property string $sid
 * @property integer $fullmptime
 * @property integer $deal
 * @property string $married
 * @property integer $injury_possible
 * @property string $labzay
 * @property integer $fcount
 * @property string $rep
 * @property string $repmoney
 * @property integer $last_battle
 * @property integer $vk_user_id
 * @property string $bpzay
 * @property integer $bpalign
 * @property integer $bpstor
 * @property integer $bpbonussila
 * @property integer $bpbonushp
 * @property string $show_advises
 * @property string $hidden
 * @property integer $battle_fin
 * @property string $gruppovuha
 * @property integer $autofight
 * @property string $expbonus
 * @property integer $wcount
 * @property integer $victorina
 * @property integer $id_grup
 * @property integer $prem
 * @property integer $hiller
 * @property integer $khiller
 * @property integer $slp
 * @property integer $trv
 * @property integer $ldate
 * @property integer $stamina
 * @property integer $odate
 * @property integer $id_city
 * @property string $ruines
 * @property integer $voinst
 * @property integer $rubashka
 * @property integer $stbat
 * @property integer $winstbat
 * @property string $citizen
 * @property integer $skulls
 * @property string $hiddenlog
 * @property integer $naim
 * @property integer $naim_war
 * @property integer $pasbaf
 * @property integer $runa1
 * @property integer $runa2
 * @property integer $runa3
 * @property integer $is_sn
 * @property string $elkbat
 * @property integer $smagic
 * @property string $unikstatus
 * @property string $change
 * @property string $rep_bonus
 */
class Users extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */

    const nclass_name = ['Не определен','Уворотчик','Критовик','Танк','Любой'];

    public static function tableName()
    {
        return 'users';
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
            [['pass', 'info', 'chattime', 'sid', 'fullmptime', 'married'], 'required'],
            [['pass', 'info'], 'string'],
            [['sex', 'icq', 'level', 'sila', 'lovk', 'inta', 'vinos', 'intel', 'mudra', 'duh', 'bojes', 'noj', 'mec', 'topor', 'dubina', 'win', 'lose', 'room', 'maxhp', 'hp', 'maxmana', 'mana', 'sergi', 'kulon', 'perchi', 'weap', 'bron', 'r1', 'r2', 'r3', 'helm', 'shit', 'boots', 'stats', 'exp', 'master', 'nextup', 'm1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7', 'm8', 'm9', 'm10', 'm11', 'm12', 'm13', 'm14', 'm15', 'nakidka', 'mfire', 'mwater', 'mair', 'mearth', 'mlight', 'mgray', 'mdark', 'fullhptime', 'zayavka', 'battle', 'battle_t', 'block', 'podarokAD', 'lab', 'bot', 'in_tower', 'chattime', 'fullmptime', 'deal', 'injury_possible', 'labzay', 'fcount', 'rep', 'repmoney', 'last_battle', 'vk_user_id', 'bpzay', 'bpalign', 'bpstor', 'bpbonussila', 'bpbonushp', 'hidden', 'battle_fin', 'autofight', 'wcount', 'victorina', 'id_grup', 'prem', 'hiller', 'khiller', 'slp', 'trv', 'ldate', 'stamina', 'odate', 'id_city', 'ruines', 'voinst', 'rubashka', 'stbat', 'winstbat', 'skulls', 'naim', 'naim_war', 'pasbaf', 'runa1', 'runa2', 'runa3', 'is_sn', 'elkbat', 'smagic', 'change'], 'integer'],
            [['money', 'ekr', 'expbonus', 'rep_bonus'], 'number'],
            [['borntime'], 'safe'],
            [['login', 'city', 'married', 'citizen'], 'string', 'max' => 50],
            [['email', 'realname', 'status', 'borncity'], 'string', 'max' => 100],
            [['second_password', 'http', 'lozung', 'palcom', 'medals', 'unikstatus'], 'string', 'max' => 255],
            [['borndate'], 'string', 'max' => 12],
            [['color'], 'string', 'max' => 7],
            [['align'], 'string', 'max' => 6],
            [['klan'], 'string', 'max' => 25],
            [['shadow'], 'string', 'max' => 60],
            [['ip', 'show_advises'], 'string', 'max' => 15],
            [['sid'], 'string', 'max' => 128],
            [['gruppovuha'], 'string', 'max' => 20],
            [['hiddenlog'], 'string', 'max' => 105],
            [['login', 'email'], 'unique', 'targetAttribute' => ['login', 'email'], 'message' => 'The combination of Login and Email has already been taken.'],
            [['login'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'email' => 'Email',
            'pass' => 'Pass',
            'second_password' => 'Second Password',
            'realname' => 'Realname',
            'borndate' => 'Borndate',
            'sex' => 'Sex',
            'city' => 'City',
            'icq' => 'Icq',
            'http' => 'Http',
            'info' => 'Info',
            'lozung' => 'Lozung',
            'color' => 'Color',
            'level' => 'Level',
            'align' => 'Align',
            'klan' => 'Klan',
            'sila' => 'Sila',
            'lovk' => 'Lovk',
            'inta' => 'Inta',
            'vinos' => 'Vinos',
            'intel' => 'Intel',
            'mudra' => 'Mudra',
            'duh' => 'Duh',
            'bojes' => 'Bojes',
            'money' => 'Money',
            'noj' => 'Noj',
            'mec' => 'Mec',
            'topor' => 'Topor',
            'dubina' => 'Dubina',
            'win' => 'Win',
            'lose' => 'Lose',
            'status' => 'Status',
            'borncity' => 'Borncity',
            'borntime' => 'Borntime',
            'room' => 'Room',
            'maxhp' => 'Maxhp',
            'hp' => 'Hp',
            'maxmana' => 'Maxmana',
            'mana' => 'Mana',
            'sergi' => 'Sergi',
            'kulon' => 'Kulon',
            'perchi' => 'Perchi',
            'weap' => 'Weap',
            'bron' => 'Bron',
            'r1' => 'R1',
            'r2' => 'R2',
            'r3' => 'R3',
            'helm' => 'Helm',
            'shit' => 'Shit',
            'boots' => 'Boots',
            'stats' => 'Stats',
            'exp' => 'Exp',
            'master' => 'Master',
            'shadow' => 'Shadow',
            'nextup' => 'Nextup',
            'm1' => 'M1',
            'm2' => 'M2',
            'm3' => 'M3',
            'm4' => 'M4',
            'm5' => 'M5',
            'm6' => 'M6',
            'm7' => 'M7',
            'm8' => 'M8',
            'm9' => 'M9',
            'm10' => 'M10',
            'm11' => 'M11',
            'm12' => 'M12',
            'm13' => 'M13',
            'm14' => 'M14',
            'm15' => 'M15',
            'm16' => 'M16',
            'm17' => 'M17',
            'm18' => 'M18',
            'm19' => 'M19',
            'm20' => 'M20',
            'nakidka' => 'Nakidka',
            'mfire' => 'Mfire',
            'mwater' => 'Mwater',
            'mair' => 'Mair',
            'mearth' => 'Mearth',
            'mlight' => 'Mlight',
            'mgray' => 'Mgray',
            'mdark' => 'Mdark',
            'fullhptime' => 'Fullhptime',
            'zayavka' => 'Zayavka',
            'battle' => 'Battle',
            'battle_t' => 'Battle T',
            'block' => 'Block',
            'palcom' => 'Palcom',
            'medals' => 'Medals',
            'ip' => 'Ip',
            'podarokAD' => 'Podarok Ad',
            'lab' => 'Lab',
            'bot' => 'Bot',
            'in_tower' => 'In Tower',
            'ekr' => 'Ekr',
            'chattime' => 'Chattime',
            'sid' => 'Sid',
            'fullmptime' => 'Fullmptime',
            'deal' => 'Deal',
            'married' => 'Married',
            'injury_possible' => 'Injury Possible',
            'labzay' => 'Labzay',
            'fcount' => 'Fcount',
            'rep' => 'Rep',
            'repmoney' => 'Repmoney',
            'last_battle' => 'Last Battle',
            'vk_user_id' => 'Vk User ID',
            'bpzay' => 'Bpzay',
            'bpalign' => 'Bpalign',
            'bpstor' => 'Bpstor',
            'bpbonussila' => 'Bpbonussila',
            'bpbonushp' => 'Bpbonushp',
            'show_advises' => 'Show Advises',
            'hidden' => 'Hidden',
            'battle_fin' => 'Battle Fin',
            'gruppovuha' => 'Gruppovuha',
            'autofight' => 'Autofight',
            'expbonus' => 'Expbonus',
            'wcount' => 'Wcount',
            'victorina' => 'Victorina',
            'id_grup' => 'Id Grup',
            'prem' => 'Prem',
            'hiller' => 'Hiller',
            'khiller' => 'Khiller',
            'slp' => 'Slp',
            'trv' => 'Trv',
            'ldate' => 'Ldate',
            'stamina' => 'Stamina',
            'odate' => 'Odate',
            'id_city' => 'Id City',
            'ruines' => 'Ruines',
            'voinst' => 'Voinst',
            'rubashka' => 'Rubashka',
            'stbat' => 'Stbat',
            'winstbat' => 'Winstbat',
            'citizen' => 'Citizen',
            'skulls' => 'Skulls',
            'hiddenlog' => 'Hiddenlog',
            'naim' => 'Naim',
            'naim_war' => 'Naim War',
            'pasbaf' => 'Pasbaf',
            'runa1' => 'Runa1',
            'runa2' => 'Runa2',
            'runa3' => 'Runa3',
            'is_sn' => 'Is Sn',
            'elkbat' => 'Elkbat',
            'smagic' => 'Smagic',
            'unikstatus' => 'Unikstatus',
            'change' => 'Change',
            'rep_bonus' => 'Rep Bonus',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\UsersQuery(get_called_class());
    }

    /**
     * @return array|Users[]
     */
    public static function getDilers()
    {
        return self::find()
            ->select(['login', 'id', 'align'])
            ->andWhere('`deal` = 1 and `login` NOT LIKE "auto%" and `id` not in (7363, 450, 8540)')
            ->orWhere('id in (83, 3154)')
            ->all();
    }

    /**
     * @return array|Users[]
     */
    public static function getClassesStats()
    {
	$time = time() - 24*3600;
        return self::find()
            ->select(['uclass','COUNT(*) AS cnt'])
            ->where('ldate >= '.$time.' and odate >= '.$time)
            ->groupBy(['uclass'])
            ->createCommand()->queryAll();
    }

}
