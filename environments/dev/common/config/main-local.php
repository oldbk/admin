<?php
return [
	'vendorPath' => '//Users/me/Work/www/oldbk/admin.local/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=88.198.205.122;dbname=oldbk_admin',
            'username' => 'oldbk_admin',
            'password' => 'BA0NUfuwOsJVxXcDKyS4',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];