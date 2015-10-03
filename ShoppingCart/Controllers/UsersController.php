<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\Models\UserModel;
use ShoppingCart\View;
use ShoppingCart\ViewModels\LoginInformationViewModel;
use ShoppingCart\ViewModels\RegisterInformationViewModel;
use ShoppingCart\ViewModels\UserViewModel;

class UsersController extends Controller
{
    public function login() {
        if ($this->isLogged()) {
            header("Location: /users/profile");
            exit();
        }

        $viewModel = new LoginInformationViewModel();

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

    public function register() {
        if ($this->isLogged()) {
            header("Location: /users/profile");
            exit();
        }

        $viewModel = new RegisterInformationViewModel();

        if (isset($_POST['username'], $_POST['password'], $_POST['firstName'], $_POST['lastName'])) {
            try {
                $user = $_POST['username'];
                $password = $_POST['password'];
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];

                $userModel = new UserModel();
                if ($userModel->exists($user)) {
                    throw new \Exception("User already registered");
                }

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
            header("Location: /users/login");
            exit();
        }

        $userModel = new UserModel();
        $userInfo = $userModel->getInfo($_SESSION['id']);

        $userViewModel = new UserViewModel(
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

            if ($userModel->edit($_POST['username'], $_POST['password'], $_SESSION['id'])) {
                $userViewModel->success = 1;
                $userViewModel->setUsername($_POST['username']);
                $userViewModel->setPassword($_POST['password']);
            }

            $userViewModel->error = 1;
            return new View($userViewModel);
        }

        return new View($userViewModel);
    }

    public function logout() {
        if (!$this->isLogged()) {
            header("Location: /users/profile");
            exit();
        }

        session_destroy();
        header("Location: /users/login");
        exit();
    }

    private function initLogin($user, $pass) {
        $userModel = new UserModel();

        $userId = $userModel->login($user, $pass);
        $_SESSION['id'] = $userId;

        $userRoles = $userModel->getUserRoles($userId);
        $_SESSION['roles'] = $userRoles;

        header("Location: profile");
    }
}