<?php
namespace ShoppingCart\Models;

use ShoppingCart\ViewModels\ProductViewModel;

class ProductModel extends Model
{
    public function all($take, $skip, $category) {
        if ($category) {
            $showAllProducts = UserModel::isAdminUser($_SESSION['id']) ? "" : "AND p.quantity > 0";

            $result = $this->db->prepare("SELECT p.id, p.name, p.quantity FROM products p
                                    INNER JOIN products_categories pc
                                    ON p.id = pc.product_id
                                    WHERE pc.category_id = (SELECT id FROM categories WHERE name = ?) $showAllProducts
                                    LIMIT ? OFFSET ?");

            $result->execute([$category, $take, $skip]);

            return $this->prepareViewModel($result->fetchAll());
        } else {
            $showAllProducts = UserModel::isAdminUser($_SESSION['id']) ? "" : "WHERE quantity > 0";
            $result = $this->db->prepare("SELECT id, name, quantity, price FROM products $showAllProducts LIMIT ? OFFSET ?");
            $result->execute([$take, $skip]);

            return $this->prepareViewModel($result->fetchAll());
        }
    }

    public function details($id) {
        $result = $this->db->prepare("SELECT id, name, quantity, price FROM products WHERE id = ?");

        $result->execute([$id]);

        return $this->prepareViewModel($result->fetchAll())[0];
    }

    public function getPossessions($take, $skip) {
        $result = $this->db->prepare("SELECT p.id, p.name, up.quantity, p.price FROM user_possessions up
                                            INNER JOIN products p
                                            ON up.product_id = p.id
                                            WHERE user_id =  ?");

        $result->execute([$_SESSION['id'], $take, $skip]);

        return $this->prepareViewModel($result->fetchAll());
    }

    public function exists($id) {
        $result = $this->db->prepare("SELECT id FROM products WHERE id = ?");

        $result->execute([$id]);

        if ($result->rowCount() > 0) {
            return true;
        }

        return false;
    }

    private function prepareViewModel($productsArray) {
        $viewModel = [];

        foreach ($productsArray as $product) {
            $price = isset($product['price']) ? $product['price'] : null;
            array_push($viewModel, new ProductViewModel($product['id'], $product['name'], $product['quantity'], $price));
        }

        return $viewModel;
    }
}