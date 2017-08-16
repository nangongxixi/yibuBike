<?php

namespace Base\Config;

class Db extends \Windward\Config\Config
{

    const master = [
        'database' => 'bicycle',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
        'option' => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ],
    ];
    
    const slave = [
        'database' => 'bicycle',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
        'option' => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ],
    ];

}
