<?php

namespace ShoppingCart\Core\Drivers;

class DriverFactory
{
    const DRIVER_MYSQL = 'mysql';

    public static function create($driver, $user, $pass, $dbName, $host = null) {
        switch ($driver) {
            case self::DRIVER_MYSQL:
                return new MySQLDriver($user, $pass, $dbName, $host);
            default:
                throw new \Exception("Invalid db driver");
        }
    }
}