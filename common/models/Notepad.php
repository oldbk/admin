<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notepad".
 *
 * @property integer $id
 * @property string $message
 * @property string $place
 * @property integer $updated_at
 */
class Notepad extends \common\models\BaseModel
{
    const PLACE_DILER   		= 'diler';
    const PLACE_NEWS    		= 'news';
    const PLACE_QUEST   		= 'quest';
    const PLACE_RECIPE  		= 'recipe';
    const PLACE_SETTINGS  		= 'settings';
    const PLACE_SETTINGS_CLASS  = 'settings_klass';
    const PLACE_SETTINGS_DAMAGE = 'settings_damage';
    const PLACE_SHOP 			= 'shop';
    const PLACE_ESHOP 			= 'eshop';
    const PLACE_CSHOP 			= 'cshop';
    const PLACE_FAIRSHOP 		= 'fairshop';
    const PLACE_CONFIG_KO 		= 'config_ko';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notepad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'place'], 'required'],
            [['message'], 'string'],
            [['updated_at'], 'integer'],
            [['place'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'place' => 'Place',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\NotepadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NotepadQuery(get_called_class());
    }
}