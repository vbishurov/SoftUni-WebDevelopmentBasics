<?php
namespace ShoppingCart\Controllers;

abstract class Controller
{
    protected function isLogged()
    {
        return isset($_SESSION['id']);
    }

    protected function getUserId() {
        return $_SESSION['id'];
    }

    protected function validatePermissions() {
        if (!$this->isLogged()) {
            header("Location: /users/login");
        }

        $isAdmin = in_array(array('name' => 'administrator'), $_SESSION['roles']);
        $isEditor = in_array(array('name' => 'editor'), $_SESSION['roles']);

        if (!$isAdmin && !$isEditor) {
            header("Location: /users/profile");
        }
    }
}