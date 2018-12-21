<?php
namespace common\models;

use common\models\loto\LotoExport;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $short_description
 *
 * @property string $password write-only password
 * @property string $password2 write-only password
 * @property string $change_password write-only password
 *
 * @property LotoExport[] $lotoExports
 * @property UserLock $userLock
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_GAMEMASTER = 'gamemaster';
    const ROLE_WORDFILTER = 'wordfilter';
    const ROLE_LIBRARY 	  = 'library';
    const ROLE_DRESSROOM  = 'dressroom';
    const ROLE_DILER  	  = 'diler';

    public $change_password = 0;
    public $password_repeat;
    private $password;

    const SCENARIO_ADMIN = 'admin_change';

    private $secretKey = 'SfzHKglEhSZtVe2g2WqD';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'status' => 'Статус',
            'short_description' => 'Краткое описание',
            'change_password' => 'Изменить пароль?',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'compare', 'when' => function($model){
                return $model->change_password;
            }],
            [['password', 'password_repeat'], 'required', 'when' => function($model){
                return $model->change_password;
            }],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['password_repeat'], 'safe'],
            [['username', 'email'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotoExports()
    {
        return $this->hasMany(LotoExport::className(), ['user_id' => 'id']);
    }

    /**
     * @return UserLock
     */
    public function getUserLock()
    {
        return $this->hasOne(UserLock::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_hash === md5($password.$this->secretKey);
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->password_hash = md5($password.$this->secretKey);

        return $this;
    }

    protected function getPassword()
    {
        return $this->password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getGenders()
    {
        return [
            self::GENDER_MALE => 'Мужской',
            self::GENDER_FEMALE => 'Женский',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Вкл.',
            self::STATUS_DELETED => 'Выкл.',
        ];
    }
}
