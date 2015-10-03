<?php
namespace ShoppingCart\Models;

use ShoppingCart\Config\DatabaseConfig;
use ShoppingCart\Core\Database;

class Model
{
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
}