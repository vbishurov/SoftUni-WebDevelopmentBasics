<?php
namespace ShoppingCart\Models;

use ShoppingCart\Config\DatabaseConfig;
use ShoppingCart\Core\Database;

class UserModel extends Model
{
    const CASH_DEFAULT = 1000;

    public static function isAdminUser($id) {
        $db = Database::getInstance(DatabaseConfig::DB_INSTANCE_NAME);

        $result = $db->prepare("SELECT id FROM users u
                                INNER JOIN users_roles r
                                ON u.id = r.user_id
                                WHERE r.role_id = (SELECT id FROM roles WHERE name = 'administrator') AND u.id = ?");

        $result->execute([$id]);

        if ($result->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function register($username, $password, $firstName, $lastName) {
        $result = $this->db->prepare("INSERT INTO users(username, password, firstname, lastname, cash) VALUES(?, ?, ?, ?, ?)");
        $result->execute([$username, password_hash($password, PASSWORD_DEFAULT), $firstName, $lastName, UserModel::CASH_DEFAULT]);

        if ($result->rowCount() > 0) {
            $userId = $this->db->lastId();
            $this->db->query("INSERT INTO users_roles (user_id, role_id) SELECT $userId, id FROM roles WHERE name='user'");

            return true;
        }

        throw new \Exception("Cannot register user");
    }

    public function exists($username) {
        $result = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $result->execute([$username]);

        return $result->rowCount() > 0;
    }

    public function login($username, $password) {
        $result = $this->db->prepare("SELECT id, username, password, firstname, lastname, cash FROM users WHERE username = ?");
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

    public function getInfo($id) {
        $result = $this->db->prepare("SELECT id, username, password, firstname, lastname, cash FROM users WHERE id = ?");
        $result->execute([$id]);

        return $result->fetch();
    }

    public function getUserRoles($id) {
        $result = $this->db->prepare("SELECT r.name from users u
                                      INNER JOIN users_roles ur
                                      ON u.id = ur.user_id
                                      INNER JOIN roles r
                                      on ur.role_id = r.id
                                      where u.id = ?");
        $result->execute([$id]);

        return $result->fetchAll();
    }

    public function edit($username, $password, $id) {
        $result = $this->db->prepare("UPDATE users SET password = ?, username = ? WHERE id = ?");
        $result->execute([password_hash($password, PASSWORD_DEFAULT), $username, $id]);

        return $result->rowCount() > 0;
    }
}