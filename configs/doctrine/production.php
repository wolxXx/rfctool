<?php
$dbName = 'rfc_tool';
if (true === defined(constant_name: 'IS_IN_TEST_ENV') && true === IS_IN_TEST_ENV) {
    $dbName .= '_test';
}

return [
    'table_prefix'  => 'rfc_tool_',
    'driver'        => 'pdo_mysql',
    'user'          => 'root',
    'host'          => 'localhost',
    'password'      => 'root',
    'dbname'        => $dbName,
    'port'          => '3306',
    'charset'       => 'utf8mb4',
    'driverOptions' => [
        \PDO\Mysql::ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    ],
];