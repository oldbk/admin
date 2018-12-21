<?php
namespace console\controllers;
use common\models\oldbk\Users;
use common\models\StatOnline;
use yii\console\Controller;

/**
 * Site controller
 */
class StatsController extends Controller
{
    public function actionOnline()
    {
        $time = new \DateTime();
        $time->setTime($time->format('G'), 0);

        $Stats = StatOnline::find()
            ->where('datetime = :datetime', [':datetime' => $time->getTimestamp()])
            ->one();
        if(!$Stats) {
            $Stats = new StatOnline();
            $Stats->datetime = $time->getTimestamp();
        }

        $count = Users::find()
            ->where('ldate >= :start_date and ldate <= :end_date', [
                ':start_date' => $time->getTimestamp(),
                ':end_date' => (new \DateTime())->setTime($time->format('G'), 59, 59)->getTimestamp()
            ])
            ->count();

        $Stats->count = $count;
        $Stats->updated_at = time();
        $Stats->save(false);

        $this->stdout(sprintf('[%s] SAVE', date('d.m.Y H:i:s')).PHP_EOL);
    }
}
