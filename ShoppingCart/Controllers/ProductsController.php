<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\Models\ProductModel;
use ShoppingCart\View;

class ProductsController extends Controller
{
    public function all($category = null, $take = 10, $skip = 0) {
        if (!$this->isLogged()) {
            header("Location: /");
            exit();
        }

        if (!$take) {
            $take = 10;
        }

        $model = new ProductModel();
        $products = $model->all($take, $skip, $category);

        return new View($products);
    }

    public function details($id) {
        $model = new ProductModel();

        if (!$model->exists($id)) {
            $error = new \stdClass();
            $error->error = "Product $id does not exist";
            return new View($error);
        }

        $product = $model->details($id);
        return new View($product);
    }

    public function possessions() {
        $model = new ProductModel();

        $possessions = $model->getPossessions($_SESSION['id']);

        return new View($possessions);
    }
}