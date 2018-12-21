<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 08.05.2016
 */

require_once __DIR__ . '/../vendor/autoload.php';

$jobby = new \Jobby\Jobby();

$jobby->add('CommandStatsOnline', array(
    'command' => '/usr/bin/php /www/a.oldbk.com/current/yii stats/online',
    'schedule' => '*/5 * * * *',
    'output' => __DIR__.'/runtime/jobby/stats_online.log',
    'enabled' => true,
    'debug' => false,
));

$jobby->add('CommandGameLoto', array(
    'command' => '/usr/bin/php /www/a.oldbk.com/current/yii game/loto',
    'schedule' => '*/2 * * * *',
    'output' => __DIR__.'/runtime/jobby/game_loto.log',
    'enabled' => true,
));

$jobby->add('CommandGameLotoMessage', array(
    'command' => '/usr/bin/php /www/a.oldbk.com/current/yii game/lotomessage',
    'schedule' => '*/2 * * * *',
    'output' => __DIR__.'/runtime/jobby/game_loto_message.log',
    'enabled' => true,
));

$jobby->run();