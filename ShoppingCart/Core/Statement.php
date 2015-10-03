<?php
namespace ShoppingCart\Core;

class Statement
{

    private $statement;

    public function __construct(\PDOStatement $statement) {
        $this->statement = $statement;
    }

    public function fetch($fetchStyle = \PDO::FETCH_ASSOC) {
        return $this->statement->fetch($fetchStyle);
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC) {
        return $this->statement->fetchAll($fetchStyle);
    }

    public function bindParam($parameter, $variable, $dataType = \PDO::PARAM_STR, $length = null, $driverOptions = null) {
        return $this->statement->bindParam($parameter, $variable, $dataType, $length, $driverOptions);
    }

    public function execute(array $inputParameters = null) {
        return $this->statement->execute($inputParameters);
    }

    public function rowCount() {
        return $this->statement->rowCount();
    }
}