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

    public function getDomains(): array 
    {
        return [];
    }

    public function deleteSubscription(string $email): void
    {
        
    }

    /**
     * Accepts email domain without '@' symbol
     */
    public function getSubscriptionsWhereDomain(string $domain): array
    {
        return [];
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