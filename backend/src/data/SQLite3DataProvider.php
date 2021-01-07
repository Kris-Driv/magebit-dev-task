<?php
namespace data;

use InvalidArgumentException;
use SQLite3;

class SQLite3DataProvider extends DataProvider {
    
    protected $connection;

    protected $needSetup = false;


    public function __construct(array $options) {
        parent::__construct($options);

        if(isset($options["database"])) {
            $file = $options["database"];
            if(!file_exists($file)) {
                touch($file);
                $this->needSetup = true;
            }
            
            $this->open();
        } else {
            throw new InvalidArgumentException("no database path was given in options");
        }
    }

    public function open()
    {
        $file = $this->options["database"];

        $this->connection = new SQLite3($file);

        if($this->needSetup) {
            $this->connection->exec(file_get_contents("resources/sql3_setup.sql"));
        }
    }

    public function query(string $q): array {
        $result = $this->connection->query($q);

        $rows = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function getAllSubscriptions(): array
    {
        return $this->query("SELECT * from subscriptions;");
    }

    /**
     * Accepts email domain without '@' symbol
     */
    public function getSubscriptionsWhereDomain(string $domain): array
    {
        $domain = SQLite3::escapeString($domain);
        return $this->query("SELECT * from subscriptions WHERE email LIKE '%@$domain%';");
    }

    public function insertNewSubscription(string $email): void
    {
        $email = SQLite3::escapeString($email);
        $stmt = $this->connection->prepare("INSERT INTO subscriptions (email, created_at) VALUES (?, ?);");
        $stmt->bindValue(1, $email, SQLITE3_TEXT);
        $stmt->bindValue(2, time(), SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function deleteSubscription(string $email): void
    {
        $email = SQLite3::escapeString($email);
        $stmt = $this->connection->prepare("DELETE FROM subscriptions WHERE email = '$email';");
    }

    public function close()
    {
        if($this->ready()) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    public function ready(): bool {
        return $this->connection instanceof SQLite3;
    }

    public function __destruct()
    {
        $this->close();
    }

}