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

        $this->dataProvider->open();

        if($this->dataProvider->ready() === false) {
            exit("Data provider failed.");
        }
    }

    public function getData() : ?DataProvider
    {
        return $this->dataProvider;
    }

    public function validateEmail(string $email): array {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [];
        } else {
            return ["$email is not a valid email"];
        }
    }

    
    /**
     *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
     *  origin.
     *
     *  In a production environment, you probably want to be more restrictive, but this gives you
     *  the general idea of what is involved.  For the nitty-gritty low-down, read:
     *
     *  - https://developer.mozilla.org/en/HTTP_access_control
     *  - https://fetch.spec.whatwg.org/#http-cors-protocol
     *
     */
    public function cors() {
        
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    }

}