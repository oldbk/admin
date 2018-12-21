<?php
namespace console\controllers;
use common\models\CronLog;
use GuzzleHttp\Client;
use yii\console\Controller;
use yii\helpers\Json;

/**
 * Site controller
 */
class GameController extends Controller
{
    public function actionLoto()
    {
        $CronLog = new CronLog();
        $CronLog->command = 'game/loto';

        $client = new Client();
        $res = $client->request('GET', 'http://capitalcity.oldbk.com/action/tools/loto');
        try {
            $data = Json::decode($res->getBody()->getContents());

            $CronLog->message = isset($data['message']) ? $data['message'] : null;
            $CronLog->trace = isset($data['trace']) ? $data['trace'] : null;
            $CronLog->code = isset($data['code']) ? $data['code'] : 0;

        } catch (\Exception $ex) {
            $CronLog->message = $ex->getMessage()."\n".$res->getBody()->getContents();
            $CronLog->trace = $ex->getTraceAsString();
            $CronLog->code = $ex->getCode();
            $data['error'] = true;
        }

        if(isset($data['error'])) {
            $CronLog->status = CronLog::STATUS_ERROR;
            $CronLog->save();
        }

        if(isset($data['success'])) {
            $CronLog->status = CronLog::STATUS_SUCCESS;
            $CronLog->save();
        }
    }

    public function actionLotomessage()
    {
        $CronLog = new CronLog();
        $CronLog->command = 'game/message';

        $client = new Client();
        $res = $client->request('GET', 'http://capitalcity.oldbk.com/action/tools/loto_message');
        try {
            $data = Json::decode($res->getBody()->getContents());

            $CronLog->message = isset($data['message']) ? $data['message'] : null;
            $CronLog->trace = isset($data['trace']) ? $data['trace'] : null;
            $CronLog->code = isset($data['code']) ? $data['code'] : 0;

        } catch (\Exception $ex) {
            $CronLog->message = $ex->getMessage()."\n".$res->getBody()->getContents();
            $CronLog->trace = $ex->getTraceAsString();
            $CronLog->code = $ex->getCode();
            $data['error'] = true;
        }

        if(isset($data['error'])) {
            $CronLog->status = CronLog::STATUS_ERROR;
            $CronLog->save();
        }

        if(isset($data['success'])) {
            $CronLog->status = CronLog::STATUS_SUCCESS;
            $CronLog->save();
        }
    }
}
