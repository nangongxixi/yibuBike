<?php

defined('ROOT') || define('ROOT', realpath('.'));

return new \Phalcon\Config(array(
    'application' => array(
        'controllersDir' => ROOT . '/app/controllers/',
        'modelsDir'      => ROOT . '/app/models/',
        'viewsDir'       => ROOT . '/app/views/',
        'baseUri'        => '/',
    )
));

//
