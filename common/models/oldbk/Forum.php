<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "forum".
 *
 * @property integer $id
 * @property integer $type
 * @property string $topic
 * @property string $text
 * @property string $date
 * @property integer $parent
 * @property integer $author
 * @property string $a_info
 * @property string $min_align
 * @property string $max_align
 * @property double $fix
 * @property integer $close
 * @property string $updated
 * @property integer $closepal
 * @property string $close_info
 * @property integer $icon
 * @property integer $del_top
 * @property integer $delpal
 * @property string $del_info
 * @property integer $deltoppal
 * @property string $deltop_info
 * @property integer $ok
 * @property string $pal_comments
 * @property integer $vote
 * @property integer $only_own
 * @property integer $is_closed
 */
class Forum extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum';
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
            [['id','type', 'parent', 'author', 'close', 'closepal', 'icon', 'del_top', 'delpal', 'deltoppal', 'ok', 'vote', 'only_own', 'is_closed'], 'integer'],
            [['text'], 'required'],
            [['text', 'pal_comments'], 'string'],
            [['fix'], 'number'],
            [['updated'], 'safe'],
            [['topic'], 'string', 'max' => 255],
            [['date'], 'string', 'max' => 14],
            [['a_info', 'close_info', 'del_info', 'deltop_info'], 'string', 'max' => 50],
            [['min_align', 'max_align'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'topic' => 'Topic',
            'text' => 'Текст поста',
            'date' => 'Date',
            'parent' => 'Parent',
            'author' => 'Author',
            'a_info' => 'Автор поста',
            'min_align' => 'Min Align',
            'max_align' => 'Max Align',
            'fix' => 'Fix',
            'close' => 'Close',
            'updated' => 'Updated',
            'closepal' => 'Closepal',
            'close_info' => 'Close Info',
            'icon' => 'Icon',
            'del_top' => 'Del Top',
            'delpal' => 'Delpal',
            'del_info' => 'Del Info',
            'deltoppal' => 'Deltoppal',
            'deltop_info' => 'Deltop Info',
            'ok' => 'Ok',
            'pal_comments' => 'Pal Comments',
            'vote' => 'Vote',
            'only_own' => 'Only Own',
            'is_closed' => 'Is Closed',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\ForumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\ForumQuery(get_called_class());
    }
}
