<?php


namespace Api\config;


class ErrorLog {
    public static function showErrors()
    {
        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', FALSE);
        ini_set('log_errors', TRUE);
        ini_set('error_log', dirname(__DIR__) . '/logs/php-error.log');
    }
}