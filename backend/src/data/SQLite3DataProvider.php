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
        } else {
            throw new InvalidArgumentException("no database path was given in options");
        }
    }

    public function open()
    {
        $file = $this->options["database"];

        $this->connection = new SQLite3($file);

        if($this->needSetup) {
            $this->setup();
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

    public function getAllSubscriptions(string $sort = "desc"): array
    {
        return $this->query("SELECT rowid AS id, * from subscriptions ORDER BY created_at {$sort};");
    }

    public function getDomains(): array {
        $all = $this->getAllSubscriptions();
        $domains = [];
        foreach($all as $row) {
            $parts = explode("@", $row["email"]);
            $domain = array_pop($parts);
            if(!in_array($domain, $domains, true)) $domains[] = $domain;
        }
        return $domains;
    }

    /**
     * Accepts email domain without '@' symbol
     */
    public function getSubscriptionsWhereDomain(string $domain, string $sort = "desc"): array
    {
        $domain = SQLite3::escapeString(strtolower($domain));
        return $this->query("SELECT * from subscriptions WHERE email LIKE '%@$domain%' ORDER BY created_at $sort;");
    }

    public function insertNewSubscription(string $email): void
    {
        $email = SQLite3::escapeString(strtolower($email));
        $stmt = $this->connection->prepare("INSERT INTO subscriptions (email, created_at) VALUES (?, ?);");
        $stmt->bindValue(1, $email, SQLITE3_TEXT);
        $stmt->bindValue(2, time(), SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function isEmailRegistered(string $email): bool {
        $email = SQLite3::escapeString(strtolower($email));
        return !empty($this->query("SELECT rowid FROM subscriptions WHERE email = '$email';"));
    }

    public function deleteSubscription(string $email): void
    {
        $email = SQLite3::escapeString(strtolower($email));
        $stmt = $this->connection->prepare("DELETE FROM subscriptions WHERE email = '$email';");
        $stmt->execute();
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

    public function setup(): void {
        $this->connection->exec(file_get_contents("resources/sql3_setup.sql"));
    }

    public function __destruct()
    {
        $this->close();
    }

}