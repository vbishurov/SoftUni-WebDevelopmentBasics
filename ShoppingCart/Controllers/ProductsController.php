<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\Models\ProductModel;
use ShoppingCart\View;
use ShoppingCart\ViewModels\InformationViewModel;

class ProductsController extends Controller
{
    public function all($category = null, $take = 10, $skip = 0) {
        if (!$this->isLogged()) {
            header("Location: /users/login");
            exit();
        }

        $model = new ProductModel();
        $products = $model->all($take, $skip, $category);

        return new View($products);
    }

    public function details($id) {
        if (!$this->isLogged()) {
            header("Location: /users/login");
            exit();
        }

        $model = new ProductModel();

        if (!$model->exists($id)) {
            $error = new \stdClass();
            $error->error = "Product $id does not exist";
            return new View($error);
        }

        $product = $model->details($id);
        return new View($product);
    }

    public function possessions($take = 10, $skip = 0) {
        if (!$this->isLogged()) {
            header("Location: /users/login");
            exit();
        }

        $model = new ProductModel();

        $possessions = $model->getPossessions($_SESSION['id'], $take, $skip);

        return new View($possessions);
    }

    public function sell($productId, $amount) {
        $productModel = new ProductModel();

        $viewModel = new InformationViewModel();
        if (!$productModel->exists($productId)) {
            $viewModel->error = "Product $productId does not exist";
            return new View($viewModel);
        }

        if ($amount < 0) {
            $viewModel->error = "You can sell at least one item";
            return new View($viewModel);
        }

        try {
            $productModel->sell($_SESSION['id'], $productId, $amount);

            $viewModel->success = "Product $productId sold successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }

    public function add($name, $quantity, $price) {
        $this->validatePermissions();

        $productModel = new ProductModel();
        $viewModel = new InformationViewModel();

        try {
            $productModel->add($name, $quantity, $price);

            $viewModel->success = "Product $name created successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }

    public function delete($productId) {
        $this->validatePermissions();

        $productModel = new ProductModel();
        $viewModel = new InformationViewModel();

        try {
            $productModel->delete($productId);

            $viewModel->success = "Product $productId deleted successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }

    public function changeStock($productId, $newQuantity) {
        $this->validatePermissions();

        $categoryModel = new ProductModel();
        $viewModel = new InformationViewModel();

        try {
            $categoryModel->changeStock($productId, $newQuantity);

            $viewModel->success = "Quantity of product $productId updated successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }
}