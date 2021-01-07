<?php
namespace data;

class MySQLDataProvider extends DataProvider {

    public function __construct(array $options) {
        parent::__construct($options);
    }
    
    public function open()
    {

    }

    public function getAllSubscriptions(): array
    {
        return [];
    }

    /**
     * Accepts email domain without '@' symbol
     */
    public function getSubscriptionsWhereDomain(string $domain): array
    {
        
    }

    public function insertNewSubscription(string $email): void
    {

    }


    public function close()
    {

    }

    public function ready(): bool 
    {
        return true; // TODO
    }

}