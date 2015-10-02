<?php
namespace ShoppingCart;

class Application
{
    private $controllerName;
    private $actionName;
    private $requestParams = [];

    private $controller;

    const CONTROLLERS_NAMESPACE = 'ShoppingCart\\Controllers\\';
    const CONTROLLERS_SUFFIX = 'Controller';

    public function __construct($controllerName, $actionName, $requestParams = []) {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->requestParams = $requestParams;
    }

    public function start() {
        $this->initController();

        View::$controllerName = $this->controllerName;
        View::$actionName = $this->actionName;

        call_user_func_array([
            $this->controller,
            $this->actionName
        ],
            $this->requestParams);
    }

    private function initController() {
        $controllerName =
            self::CONTROLLERS_NAMESPACE
            . $this->controllerName
            . self::CONTROLLERS_SUFFIX;

        if ($controllerName == "ShoppingCart\\Controllers\\Controller") {
            $controllerName = "ShoppingCart\\Controllers\\UsersController";

            $this->controllerName = 'users';
            $this->actionName = 'login';
        }

        $this->controller = new $controllerName();
    }
}