<?php
namespace frontend\controllers;

use common\models\User;
use dpodium\yii2\geoip\components\GeoIP;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['gamemaster'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error', 'socket'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            switch (true) {
                case !Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER):
                    $this->redirect(['wordfilter/wordfilter/index']);
                    break;
                default:
                    return $this->goBack();
                    break;
            }

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $User = new User();
        $User->setPassword('123123');
        $User->username = 'Мимоза';
        $User->email = 'test@oldbk.com';
        $User->status = 10;
        $User->short_description = 'QA';
        $User->save();

        $User = new User();
        $User->setPassword('123123');
        $User->username = 'Архитектор';
        $User->email = 'test@oldbk.com';
        $User->status = 10;
        $User->short_description = 'Administator';
        $User->save();

        $User = new User();
        $User->setPassword('123123');
        $User->username = 'Денис';
        $User->email = 'test@oldbk.com';
        $User->status = 10;
        $User->short_description = 'QA';
        $User->save();
    }

    public function actionSocket($command = null)
    {
        if(!$command) {
            $command = 'summary';
        }

        echo '<pre>';
        $r = $this->request($command);
        echo print_r($r, true)."\n";
    }

    private function getsock($addr, $port)
    {
        $socket = null;
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false || $socket === null)
        {
            $error = socket_strerror(socket_last_error());
            $msg = "socket create(TCP) failed";
            echo "ERR: $msg '$error'\n";
            return null;
        }
        $res = socket_connect($socket, $addr, $port);
        if ($res === false)
        {
            $error = socket_strerror(socket_last_error());
            $msg = "socket connect($addr,$port) failed";
            echo "ERR: $msg '$error'\n";
            socket_close($socket);
            return null;
        }
        return $socket;
    }
#
# Slow ...
    private function readsockline($socket)
    {
        $line = '';
        while (true)
        {
            $byte = socket_read($socket, 1);
            if ($byte === false || $byte === '')
                break;
            if ($byte === "\0")
                break;
            $line .= $byte;
        }
        return $line;
    }
#
    private function request($cmd)
    {
        $socket = $this->getsock('130.185.52.125', 4028);
        if ($socket != null)
        {
            socket_write($socket, $cmd, strlen($cmd));
            $line = $this->readsockline($socket);
            socket_close($socket);
            if (strlen($line) == 0)
            {
                echo "WARN: '$cmd' returned nothing\n";
                return $line;
            }
            print "$cmd returned '$line'\n";
            if (substr($line,0,1) == '{')
                return json_decode($line, true);
            $data = array();
            $objs = explode('|', $line);
            foreach ($objs as $obj)
            {
                if (strlen($obj) > 0)
                {
                    $items = explode(',', $obj);
                    $item = $items[0];
                    $id = explode('=', $items[0], 2);
                    if (count($id) == 1 or !ctype_digit($id[1]))
                        $name = $id[0];
                    else
                        $name = $id[0].$id[1];
                    if (strlen($name) == 0)
                        $name = 'null';
                    if (isset($data[$name]))
                    {
                        $num = 1;
                        while (isset($data[$name.$num]))
                            $num++;
                        $name .= $num;
                    }
                    $counter = 0;
                    foreach ($items as $item)
                    {
                        $id = explode('=', $item, 2);
                        if (count($id) == 2)
                            $data[$name][$id[0]] = $id[1];
                        else
                            $data[$name][$counter] = $id[0];
                        $counter++;
                    }
                }
            }
            return $data;
        }
        return null;
    }
}
