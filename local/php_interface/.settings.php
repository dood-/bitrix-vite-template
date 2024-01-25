<?php

use Bitrix\Main\DB\MysqliConnection;
use Dotenv\Dotenv;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

return array(
    'utf_mode' =>
        array(
            'value' => true,
            'readonly' => true,
        ),
    'cache_flags' =>
        array(
            'value' =>
                array(
                    'config_options' => 3600,
                    'site_domain' => 3600,
                ),
            'readonly' => false,
        ),
    'cookies' =>
        array(
            'value' =>
                array(
                    'secure' => false,
                    'http_only' => true,
                ),
            'readonly' => false,
        ),
    'exception_handling' =>
        array(
            'value' =>
                array(
                    'debug' => true,
                    'handled_errors_types' => 4437,
                    'exception_errors_types' => 4437,
                    'ignore_silence' => false,
                    'assertion_throws_exception' => true,
                    'assertion_error_type' => 256,
                    'log' => null,
                ),
            'readonly' => false,
        ),
    'crypto' =>
        array(
            'value' =>
                array(
                    'crypto_key' => env('CRYPTO_KEY'),
                ),
            'readonly' => true,
        ),
    'connections' =>
        array(
            'value' =>
                array(
                    'default' =>
                        array(
                            'className' => MysqliConnection::class,
                            'host' => env('DB_HOST'),
                            'database' => env('DB_DATABASE'),
                            'login' => env('DB_USER'),
                            'password' => env('DB_PASSWORD'),
                            'options' => 2,
                        ),
                ),
            'readonly' => true,
        ),
);
