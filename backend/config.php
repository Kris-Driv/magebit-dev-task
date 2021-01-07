<?php

define('MYSQL_HOST', '127.0.0.1');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DATABASE', 'pineapple');

define('SQLITE3_DATABASE', './pineapple.db');

// I will not bother implementing environments

$config = [
    "connection" => "sql3",

    "mysql" => [
        "host" => MYSQL_HOST,
        "user" => MYSQL_USER,
        "password" => MYSQL_PASSWORD,
        "database" => MYSQL_DATABASE
    ],

    "sql3" => [
        "database" => SQLITE3_DATABASE
    ]
];