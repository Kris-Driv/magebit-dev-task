<?php

define('MYSQL_HOST', 'localhost');
define('MYSQL_PORT', 3306);
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DATABASE', 'pineapple');

define('SQLITE3_DATABASE', './pineapple.db');

// I will not bother implementing environments

$config = [
    "connection" => "sql3",

    "mysql" => [
        "host" => MYSQL_HOST,
        "port" => MYSQL_PORT,
        "user" => MYSQL_USER,
        "password" => MYSQL_PASSWORD,
        "database" => MYSQL_DATABASE
    ],

    "sql3" => [
        "database" => SQLITE3_DATABASE
    ]
];