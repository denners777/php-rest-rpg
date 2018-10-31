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

return [
    'settings' => [
        'displayErrorDetails'    => false,
        'addContentLengthHeader' => false,
        'renderer'               => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        'logger'                 => [
            'name'  => 'sia-extensao',
            'path'  => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/' . date('Ymd') . '.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
