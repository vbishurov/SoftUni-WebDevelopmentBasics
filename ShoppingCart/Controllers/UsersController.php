<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\Models\User;
use ShoppingCart\View;
use ShoppingCart\ViewModels\LoginInformation;
use ShoppingCart\ViewModels\RegisterInformation;

class UsersController extends Controller
{
    public function login() {
        if ($this->isLogged()) {
            if ($_SERVER['REQUEST_URI'] == "/") {
                header("Location: users/profile");
            } else {
                header("Location: profile");
            }
            exit();
        }

        $viewModel = new LoginInformation();

        if (isset($_POST['username'], $_POST['password'])) {
            try {
                $user = $_POST['username'];
                $pass = $_POST['password'];

                $this->initLogin($user, $pass);
            } catch (\Exception $e) {
                $viewModel->error = $e->getMessage();
                return new View($viewModel);
            }
        }

        return new View($viewModel);
    }

    private function initLogin($user, $pass) {
        $userModel = new User();

        $userId = $userModel->login($user, $pass);
        $_SESSION['id'] = $userId;
        header("Location: profile");
    }

    public function register() {
        if ($this->isLogged()) {
            if ($_SERVER['REQUEST_URI'] == "/") {
                header("Location: users/profile");
            } else {
                header("Location: profile");
            }
            exit();
        }

        $viewModel = new RegisterInformation();

        if (isset($_POST['username'], $_POST['password'], $_POST['firstName'], $_POST['lastName'])) {
            try {
                $user = $_POST['username'];
                $password = $_POST['password'];
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];

                $userModel = new User();
                $userModel->register($user, $password, $firstName, $lastName);

                $this->initLogin($user, $password);
            } catch (\Exception $e) {
                $viewModel->error = $e->getMessage();
                return new View($viewModel);
            }
        }

        return new View($viewModel);
    }

    public function profile() {
        if (!$this->isLogged()) {
            header("Location: login");
            exit();
        }

        $userModel = new User();
        $userInfo = $userModel->getInfo($_SESSION['id']);

        $userViewModel = new \ShoppingCart\ViewModels\User(
            $userInfo['username'],
            $userInfo['password'],
            $userInfo['id'],
            $userInfo['firstname'],
            $userInfo['lastname'],
            $userInfo['cash']
        );

        if (isset($_POST['edit'])) {
            if ($_POST['password'] != $_POST['confirm'] || empty($_POST['password'])) {
                $userViewModel->error = 1;
                return new View($userViewModel);
            }

            if ($userModel->edit(
                $_POST['username'],
                $_POST['password'],
                $_SESSION['id']
            )
            ) {
                $userViewModel->success = 1;
                $userViewModel->setUsername($_POST['username']);
                $userViewModel->setPassword($_POST['password']);

                return new View($userViewModel);
            }

            $userViewModel->error = 1;
            return new View($userViewModel);
        }

        return new View($userViewModel);
    }

    public function logout() {
        if (!$this->isLogged()) {
            header("Location: profile");
            exit();
        }

        unset($_SESSION['id']);
        header("Location: login");
        exit();
    }
}