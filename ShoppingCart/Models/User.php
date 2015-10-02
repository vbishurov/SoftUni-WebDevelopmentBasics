<?php
namespace ShoppingCart\Models;

use ShoppingCart\Config\DatabaseConfig;
use ShoppingCart\Core\Database;

class User
{
    const CASH_DEFAULT = 1000;

    public function register($username, $password, $firstName, $lastName) {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);

        if ($this->exists($username)) {
            throw new \Exception("User already registered");
        }

        $result = $db->prepare("INSERT INTO users(username, password, firstname, lastname, cash) VALUES(?, ?, ?, ?, ?)");
        $result->execute([$username, password_hash($password, PASSWORD_DEFAULT), $firstName, $lastName, User::CASH_DEFAULT]);

        if ($result->rowCount() > 0) {
            $userId = $db->lastId();

            $db->query("INSERT INTO users_roles (user_id, role_id) SELECT $userId, id FROM roles WHERE name='user'");

            return true;
        }

        throw new \Exception("Cannot register user");
    }

    public function exists($username)
    {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);

        $result = $db->prepare("SELECT id FROM users WHERE username = ?");
        $result->execute([ $username ]);

        return $result->rowCount() > 0;
    }

    public function login($username, $password) {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);

        $result = $db->prepare("SELECT id, username, password, firstname, lastname, cash FROM users WHERE username = ?");
        $result->execute([$username]);

        if ($result->rowCount() <= 0) {
            throw new \Exception("Invalid username!");
        }

        $userRow = $result->fetch();

        if (!password_verify($password, $userRow['password'])) {
            throw new \Exception("Invalid password");
        }

        return $userRow['id'];
    }

    public function getInfo($id)
    {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);

        $result = $db->prepare("SELECT id, username, password, firstname, lastname, cash FROM users WHERE id = ?");
        $result->execute([$id]);

        return $result->fetch();
    }

    public function edit($username, $password, $id)
    {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);

        $result = $db->prepare("UPDATE users SET password = ?, username = ? WHERE id = ?");
        $result->execute([
            password_hash($password, PASSWORD_DEFAULT),
            $username,
            $id
        ]);

        return $result->rowCount() > 0;
    }
}