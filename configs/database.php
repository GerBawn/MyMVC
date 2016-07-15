<?php
/**
 * User: GerBawn
 * Date: 2016/4/5 23:56
 */

$config = [
    'driver' => 'pdo',
    'default' => [
        'type' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'password' => 'Lingchen_410',
        'dbname' => 'test',
    ],
    'test' => [
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'password' => 'Lingchen_410',
        'dbname' => 'test1',
    ]
];

return $config;