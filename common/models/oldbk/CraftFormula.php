<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "craft_formula".
 *
 * @property integer $craftid
 * @property integer $craftprotoid
 * @property integer $craftprototype
 * @property integer $craftprotocount
 * @property integer $crafttime
 * @property string $craftnalign
 * @property integer $craftnlevel
 * @property string $craftnres
 * @property integer $craftgetexp
 * @property integer $craftloc
 * @property integer $craftrazdel
 * @property integer $craftgetprof
 * @property integer $craftcomplexity
 * @property integer $craftnsila
 * @property integer $craftnlovk
 * @property integer $craftninta
 * @property integer $craftnvinos
 * @property integer $craftnintel
 * @property integer $craftnmudra
 * @property integer $craftnnoj
 * @property integer $craftntopor
 * @property integer $craftndubina
 * @property integer $craftnmech
 * @property integer $craftnfire
 * @property integer $craftnwater
 * @property integer $craftnair
 * @property integer $craftnearth
 * @property integer $craftnlight
 * @property integer $craftngray
 * @property integer $craftndark
 * @property integer $is_enabled
 * @property integer $is_vaza
 * @property integer $is_deleted
 * @property integer $craftnprofhunter
 * @property integer $craftnprofwoodman
 * @property integer $craftnprofminer
 * @property integer $craftnproffarmer
 * @property integer $craftnprofherbalist
 * @property integer $craftnprofcook
 * @property integer $craftnprofsmith
 * @property integer $craftnprofarmorer
 * @property integer $craftnprofarmorsmith
 * @property integer $craftnproftailor
 * @property integer $craftnprofjeweler
 * @property integer $craftnprofalchemist
 * @property integer $craftnprofmage
 * @property integer $craftnprofcarpenter
 * @property integer $craftnprofprospector
 * @property integer $craftmfchance
 */
class CraftFormula extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'craft_formula';
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
            [['craftid', 'craftnres'], 'required'],
            [['craftid', 'craftprotoid', 'craftprototype', 'craftprotocount', 'crafttime', 'craftnlevel', 'craftgetexp', 'craftloc', 'craftrazdel', 'craftgetprof', 'craftcomplexity', 'craftnsila', 'craftnlovk', 'craftninta', 'craftnvinos', 'craftnintel', 'craftnmudra', 'craftnnoj', 'craftntopor', 'craftndubina', 'craftnmech', 'craftnfire', 'craftnwater', 'craftnair', 'craftnearth', 'craftnlight', 'craftngray', 'craftndark', 'is_enabled', 'is_deleted', 'craftnprofhunter', 'craftnprofwoodman', 'craftnprofminer', 'craftnproffarmer', 'craftnprofherbalist', 'craftnprofcook', 'craftnprofsmith', 'craftnprofarmorer', 'craftnprofarmorsmith', 'craftnproftailor', 'craftnprofjeweler', 'craftnprofalchemist', 'craftnprofmage', 'craftnprofcarpenter' ,'craftnprofprospector', 'craftmfchance', 'is_vaza','craftgoden','craftnotsell','craftsowner','craftis_present','craftunik','craftnaem'], 'integer'],
            [['craftnres','craftpresent'], 'string'],
            [['craftnalign'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'craftid' => 'Craftid',
            'craftprotoid' => 'Craftprotoid',
            'craftprototype' => 'Craftprototype',
            'craftprotocount' => 'Craftprotocount',
            'crafttime' => 'Crafttime',
            'craftnalign' => 'Craftnalign',
            'craftnlevel' => 'Craftnlevel',
            'craftnres' => 'Craftnres',
            'craftgetexp' => 'Craftgetexp',
            'craftloc' => 'Craftloc',
            'craftrazdel' => 'Craftrazdel',
            'craftgetprof' => 'Craftgetprof',
            'craftcomplexity' => 'Craftcomplexity',
            'craftnsila' => 'Craftnsila',
            'craftnlovk' => 'Craftnlovk',
            'craftninta' => 'Craftninta',
            'craftnvinos' => 'Craftnvinos',
            'craftnintel' => 'Craftnintel',
            'craftnmudra' => 'Craftnmudra',
            'craftnnoj' => 'Craftnnoj',
            'craftntopor' => 'Craftntopor',
            'craftndubina' => 'Craftndubina',
            'craftnmech' => 'Craftnmech',
            'craftnfire' => 'Craftnfire',
            'craftnwater' => 'Craftnwater',
            'craftnair' => 'Craftnair',
            'craftnearth' => 'Craftnearth',
            'craftnlight' => 'Craftnlight',
            'craftngray' => 'Craftngray',
            'craftndark' => 'Craftndark',
            'is_enabled' => 'Is Enabled',
            'is_vaza' => 'Is Vaza',
            'is_deleted' => 'Is Deleted',
            'craftnprofhunter' => 'Craftnprofhunter',
            'craftnprofwoodman' => 'Craftnprofwoodman',
            'craftnprofminer' => 'Craftnprofminer',
            'craftnproffarmer' => 'Craftnproffarmer',
            'craftnprofherbalist' => 'Craftnprofherbalist',
            'craftnprofcook' => 'Craftnprofcook',
            'craftnprofsmith' => 'Craftnprofsmith',
            'craftnprofarmorer' => 'Craftnprofarmorer',
            'craftnprofarmorsmith' => 'Craftnprofarmorsmith',
            'craftnproftailor' => 'Craftnproftailor',
            'craftnprofjeweler' => 'Craftnprofjeweler',
            'craftnprofalchemist' => 'Craftnprofalchemist',
            'craftnprofmage' => 'Craftnprofmage',
            'craftnprofcarpenter' => 'Craftnprofcarpenter',
            'craftnprofprospector' => 'Craftnprofprospector',
            'craftmfchance' => 'CraftFormula',
            'craftnaem' => 'CraftNaem'
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\CraftFormulaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\CraftFormulaQuery(get_called_class());
    }
}
