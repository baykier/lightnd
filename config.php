<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 15:15
 */
$config = array();

$config['db'] = array(
    'driver' => 'mysql',
    'default' => array(
        'dbname' => 'lightnd',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
        'query' => 'SET NAMES utf8 ',
    ),
);

return $config;