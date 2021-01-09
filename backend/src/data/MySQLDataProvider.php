<?php
namespace data;

use mysqli;
use mysqli_result;

class MySQLDataProvider extends DataProvider {
    
    protected $connection;

    public function open()
    {
        $this->connection = new mysqli(
            $this->options["host"],
            $this->options["user"],
            $this->options["password"],
            $this->options["database"],
            $this->options["port"] ?? 3306
        );

        if($this->connection->connect_errno) {
            throw new \Exception("Error while connecting to database: " . $this->connection->connect_error);
        }

        // should run once
        $this->setup();
    }

    public function query(string $q) {
        $result = $this->connection->query($q);
        if(!$result) {
            var_dump($this->connection);
        } 

        if($result instanceof mysqli_result) {
            $rows = [];
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        }
        return [];
    }

    public function getAllSubscriptions(): array
    {
        return $this->query("SELECT * from subscriptions;");
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
    public function getSubscriptionsWhereDomain(string $domain): array
    {
        $domain = mysqli_escape_string($this->connection, strtolower($domain));
        return $this->query("SELECT * from subscriptions WHERE email LIKE '%@$domain%';");
    }

    public function insertNewSubscription(string $email): void
    {
        $email = mysqli_escape_string($this->connection, strtolower($email));
        if($stmt = $this->connection->prepare("INSERT INTO subscriptions (email, created_at) VALUES (?, ?);")) {
            $t = time();
            $stmt->bind_param("si", $email, $t);
            if(!$stmt->execute()) {
                throw new \Exception("Query failed: (" . $this->connection->errno . ") " . $this->connection->error);
            }
        } else {
            throw new \Exception("Prepare failed: (" . $this->connection->errno . ") " . $this->connection->error);
        }
        
        $stmt->execute();
    }

    public function isEmailRegistered(string $email): bool {
        $email = mysqli_escape_string($this->connection, strtolower($email));
        return !empty($this->query("SELECT * FROM subscriptions WHERE email = '$email';"));
    }

    public function deleteSubscription(string $email): void
    {
        $email = mysqli_escape_string($this->connection, strtolower($email));
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
        return $this->connection instanceof mysqli;
    }

    public function setup(): void {
        $this->query(file_get_contents("resources/mysql_setup.sql"));
    }

    public function __destruct()
    {
        $this->close();
    }

}