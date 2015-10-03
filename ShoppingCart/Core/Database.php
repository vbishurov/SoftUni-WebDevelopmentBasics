<?php

namespace ShoppingCart\Core;

use ShoppingCart\Core\Drivers\DriverFactory;

class Database
{
    private static $instances = [];

    private $db;

    private function __construct(\PDO $db) {
        $this->db = $db;
    }

    public static function getInstance($instanceName = 'default') {
        if (!isset(self::$instances[$instanceName])) {
            throw new \Exception('Instance with that name was not set');
        }

        return self::$instances[$instanceName];
    }

    public static function setInstance($instanceName, $driver, $user, $pass, $dbName, $host = null) {
        $driver = DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO($driver->getDsn(), $user, $pass);

        self::$instances[$instanceName] = new self($pdo);
    }

    public function prepare($statement, array $driverOptions = []) {
        $statement = $this->db->prepare($statement, $driverOptions);
        return new Statement($statement);
    }

    public function query($query) {
        $this->db->query($query);
    }

    public function lastId($name = null) {
        return $this->db->lastInsertId($name);
    }

    public function setAttribute($attribute, $value) {
        return $this->db->setAttribute($attribute, $value);
    }

    public function beginTransaction () {
        return $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack  () {
        return $this->db->rollBack();
    }
}