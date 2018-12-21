<?php

namespace common\models\oldbk;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use common\models\oldbk\Shop;

/**
 * This is the model class for table "users_fortune_stats".
 *
 * @property string $id
 * @property string $owner
 * @property integer $date
 * @property integer $status
 * @property string $itemproto
 * @property string $itemcount
 */
class UsersFortuneStats extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_fortune_stats';
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
            [['owner', 'date', 'status', 'itemproto', 'itemcount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner' => 'Owner',
            'date' => 'Date',
            'status' => 'Status',
            'itemproto' => 'Itemproto',
            'itemcount' => 'Itemcount',
        ];
    }

    public static function getUnikOwnerStat($datefrom,$dateto)
    {
        return self::find()
            ->select(['COUNT(DISTINCT owner) as cc'])
            ->where('date >= '.$datefrom.' and date <= '.$dateto)
            ->createCommand()->queryAll();
    }

    public static function getStatusStat($datefrom,$dateto)
    {
        return self::find()
            ->select(['status','COUNT(*) as cc'])
            ->where('date >= '.$datefrom.' and date <= '.$dateto)
            ->groupBy(['status'])
            ->createCommand()->queryAll();
    }

    public static function getItemStat($datefrom,$dateto) 
    {
	$query = new Query();
        $query->select("s.name, sum(i.itemcount) as cc ")->from(self::tableName().' i')->leftJoin(Shop::tableName(). ' s','s.id = i.itemproto')->where(['>=','date',$datefrom])->andWhere(['<=','date',$dateto])->groupBy("itemproto")->orderBy(['cc' => SORT_DESC]);

       	$dataProvider = new ActiveDataProvider([
		'query' => $query,
		'db' => 'db_oldbk',
		'pagination' => [
		        'pageSize' => -1,
		],
	]);

	return $dataProvider;

    }
}