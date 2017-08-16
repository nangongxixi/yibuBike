<?php

error_reporting(7);

define('ROOT', realpath('..'));
define('APP_PATH',ROOT . '/app');

try {
    $config = include ROOT . "/app/config/config.php";
    $codeConfig = include ROOT . "/app/config/code.php";
    include ROOT . "/app/config/loader.php";
    include ROOT . "/app/config/const.php";
    include ROOT . "/app/config/services.php";
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo $e->getMessage();
}

//
