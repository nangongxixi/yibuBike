<?php

$router = new \Phalcon\Mvc\Router();

$router->setDefaults(array(
    'controller' => 'api',
    'action' => 'index'
));

$router->handle();

return $router;

//
