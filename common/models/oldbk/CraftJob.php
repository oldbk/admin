<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_job".
 *
 * @property integer $id
 * @property integer $owner
 * @property integer $loc
 * @property integer $itemcount
 * @property integer $itemleft
 * @property integer $crafttime
 * @property integer $craftlefttime
 * @property integer $status
 * @property integer $jobprotoid
 * @property integer $jobprototype
 * @property string $itemname
 * @property integer $rcid
 * @property string $itemimg
 * @property integer $insproto
 * @property string $linkcache
 * @property integer $craftchance
 */
class CraftJob extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'craft_job';
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
            [['owner', 'loc', 'itemcount', 'itemleft', 'crafttime', 'craftlefttime', 'status', 'jobprotoid', 'jobprototype', 'rcid', 'insproto', 'craftchance'], 'integer'],
            [['itemname', 'itemimg', 'linkcache'], 'string', 'max' => 255],
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
            'loc' => 'Loc',
            'itemcount' => 'Itemcount',
            'itemleft' => 'Itemleft',
            'crafttime' => 'Crafttime',
            'craftlefttime' => 'Craftlefttime',
            'status' => 'Status',
            'jobprotoid' => 'Jobprotoid',
            'jobprototype' => 'Jobprototype',
            'itemname' => 'Itemname',
            'rcid' => 'Rcid',
            'itemimg' => 'Itemimg',
            'insproto' => 'Insproto',
            'linkcache' => 'Linkcache',
            'craftchance' => 'Craftchance',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CraftJobQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftJobQuery(get_called_class());
    }
}
