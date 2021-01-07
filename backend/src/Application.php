<?php

use data\DataProvider;
use data\MySQLDataProvider;
use data\SQLite3DataProvider;

class Application {

    protected ?DataProvider $dataProvider;

    public function __construct(array $config) {
        switch($config["connection"]) {
            case "mysql":
                $this->dataProvider = new MySQLDataProvider($config["mysql"]);
                break;
            case "sql3":
                $this->dataProvider = new SQLite3DataProvider($config["sql3"]);
                break;
            default: throw new \InvalidArgumentException("unsupported data provider type '{$config['connection']}'");
        }

        if($this->dataProvider->ready() === false) {
            exit("Data provider failed.");
        }
    }

    public function getData() : ?DataProvider
    {
        return $this->dataProvider;
    }

    public function validateEmail(): array {
        return [];
    }

}