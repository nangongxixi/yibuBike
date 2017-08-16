<?php

use Phalcon\Mvc\View;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

$di = new FactoryDefault();

$di->setShared('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.html' => function ($view, $di) use ($config) {
            $volt = new VoltEngine($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));
            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));
    return $view;
});

$di->set('router', function(){
    return require 'routes.php';
});

$di->set('code', function() use ($codeConfig) {
    return $codeConfig;
});
    
//
