<?php

ini_set('display_errors', true);
ini_set('display_startup_erros', true);
ini_set('error_reporting', E_ALL);


date_default_timezone_set('America/Sao_paulo');

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'));
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

if (!getenv('DEBUG')) {
    ini_set('display_errors', false);
    ini_set('display_startup_erros', false);
    ini_set('error_reporting', 0);
}

return [
    'settings' => [
        'displayErrorDetails'    => getenv('DEBUG'),
        'addContentLengthHeader' => false,
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        'logger' => [
            'name'  => 'sia-extensao',
            'path'  => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/' . date('Ymd') . '.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'driver'    => getenv('DB_DRIVER'),
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_NAME'),
            'username'  => getenv('DB_USER'),
            'password'  => getenv('DB_PASS'),
            'port'      => getenv('DB_PORT'),
            'schema'    => getenv('DB_SCHEMA'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'options'   => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            ],
        ]
    ],
];
