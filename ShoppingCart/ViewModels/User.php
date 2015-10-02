<?php
namespace ShoppingCart\ViewModels;

class User
{
    private $id;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $cash;

    public function __construct($username, $password, $id, $firstName = null, $lastName = null, $cash = null) {
        $this->setUsername($username)
            ->setPassword($password)
            ->setId($id)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setCash($cash);
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCash() {
        return $this->cash;
    }

    public function setCash($cash) {
        $this->cash = $cash;
        return $this;
    }
}