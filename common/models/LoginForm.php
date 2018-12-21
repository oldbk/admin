<?php
namespace common\models;

use dpodium\yii2\geoip\components\GeoIP\GeoIP_Location;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password', 'geo'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function geo($attribute, $params)
    {
        if (!$this->hasErrors()) {

            /** @var GeoIP_Location $location */
            $location = Yii::$app->geoip->lookupLocation();
            $lock = $this->getUser()->userLock;
            if(!$lock) {
				$Log = new LogGeo();
				$Log->user_id = $this->getUser()->id;
				$Log->country_code = $location->countryCode;
				$Log->country = $location->countryName;
				$Log->city = $location->city;
				$Log->ip = Yii::$app->getRequest()->getUserIP();
				$Log->save();

                return;
            }

            try {
                if($lock->ip && $lock->ip != Yii::$app->getRequest()->getUserIP()) {
                    throw new \Exception;
                }
                if($lock->city && $lock->city != $location->city) {
                    throw new \Exception;
                }
                if($lock->country && $lock->country != $location->countryName) {
                    throw new \Exception;
                }
                if($lock->country_code && $lock->country_code != $location->countryCode) {
                    throw new \Exception;
                }
            } catch (\Exception $ex) {
                $this->addError($attribute, 'Неправильный логин или пароль');

                $Log = new LogGeo();
                $Log->user_id = $this->getUser()->id;
                $Log->country_code = $location->countryCode;
                $Log->country = $location->countryName;
                $Log->city = $location->city;
                $Log->ip = Yii::$app->getRequest()->getUserIP();
                $Log->save();
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
