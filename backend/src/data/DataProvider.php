<?php
namespace data;

abstract class DataProvider {

    protected array $options = [];

    public function __construct(array $options = []) {
        $this->options = $options;
    }

    public abstract function open();

    public abstract function getAllSubscriptions(): array;

    public abstract function getDomains(): array;

    public abstract function getSubscriptionsWhereDomain(string $email): array;

    public abstract function insertNewSubscription(string $email): void;

    public abstract function deleteSubscription(string $email): void;

    public abstract function isEmailRegistered(string $email): bool;

    public abstract function close();

    public abstract function ready(): bool;

}