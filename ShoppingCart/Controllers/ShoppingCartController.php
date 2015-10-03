<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\Models\ProductModel;
use ShoppingCart\Models\CartModel;
use ShoppingCart\View;
use ShoppingCart\ViewModels\ProductAddInformationViewModel;
use ShoppingCart\ViewModels\CartCheckoutInformationViewModel;

class ShoppingCartController extends Controller
{
    public function add() {
        if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
            header("Location: /products/all");
        }

        if (!$this->isLogged()) {
            header("Location: /users/login");
        }

        $productId = $_POST['id'];
        $quantityWanted = $_POST['quantity'];
        $userId = (string)$_SESSION['id'];

        $product = new ProductModel();
        $viewModel = new ProductAddInformationViewModel();

        if (!$product->exists($productId)) {
            $viewModel->error = "Product $productId does not exist";
            return new View($viewModel);
        }

        $quantityAvailable = $product->details($productId)->getQuantity();

        if ($quantityWanted > $quantityAvailable) {
            $viewModel->error = "Not enough stock";
            return new View($viewModel);
        }

        $shoppingCart = new CartModel();
        if ($shoppingCart->add($userId, $productId, $quantityWanted)) {
            $viewModel->success = "Product $productId added to cart successfully";
            return new View($viewModel);
        } else {
            $viewModel->error = "Cannot add product $productId to cart";
            return new View($viewModel);
        }
    }

    public function view() {
        if (!$this->isLogged()) {
            header("Location: /users/login");
        }

        $shoppingCartModel = new CartModel();

        try{
            $info = $shoppingCartModel->getInfo($_SESSION['id']);

            return new View($info);
        } catch (\Exception $e) {
            $error = new \stdClass();
            $error->error = $e->getMessage();
            return new View($error);
        }
    }

    public function checkout() {
        if (!$this->isLogged()) {
            header("Location: /users/login");
        }

        $shoppingCartModel = new CartModel();
        $viewModel = new CartCheckoutInformationViewModel();

        try{
            $shoppingCartModel->checkout($_SESSION['id']);

            $viewModel->success = "Products bough successfully";

            return new View($viewModel);
        } catch (\Exception $e) {
            $viewModel->error = $e->getMessage();
            return new View($viewModel);
        }
    }
}