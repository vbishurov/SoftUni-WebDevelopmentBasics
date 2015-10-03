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

    public function getPossessions($id, $take, $skip) {
        $result = $this->db->prepare("SELECT p.id, p.name, up.quantity, p.price FROM user_possessions up
                                            INNER JOIN products p
                                            ON up.product_id = p.id
                                            WHERE user_id =  ? AND up.quantity > 0
                                            LIMIT ? OFFSET ?");

        $result->execute([$id, $take, $skip]);

        return $this->prepareViewModel($result->fetchAll());
    }

    public function sell($userId, $productId, $amount) {
        $product = $this->details($productId);
        $amountPossessed = $this->db->prepare("SELECT quantity FROM user_possessions WHERE product_id = ? AND user_id = ?");
        $amountPossessed->execute([$productId, $userId]);
        $amountPossessed = $amountPossessed->fetch();

        if ($amount > $amountPossessed) {
            throw new \Exception("You do not have $amount items from product $productId");
        }

        $this->db->beginTransaction();

        $addMoney = $this->db->prepare("UPDATE users SET cash = cash + ? WHERE id = ?");
        if (!$addMoney->execute([$product->getPrice(), $userId])) {
            $this->db->rollback();
            throw new \Exception("Cannot add money");
        }

        $removeFromPossessions = $this->db->prepare("UPDATE user_possessions SET quantity = quantity - ? WHERE user_id = ? AND product_id = ?");
        if (!$removeFromPossessions->execute([$amount, $userId, $productId])) {
            $this->db->rollback();
            throw new \Exception("Could not remove from possessions");
        }

        $addToProducts = $this->db->prepare("UPDATE products SET quantity = quantity + ? WHERE id = ?");
        if (!$addToProducts->execute([$amount, $productId])) {
            $this->db->rollback();
            throw new \Exception("Could not add to products");
        }

        $this->db->commit();
    }

    public function add($name, $quantity, $price) {
        $result = $this->db->prepare("INSERT INTO products (name, quantity, price) VALUES (?, ?, ?)");
        if (!$result->execute([$name, $quantity, $price])) {
            throw new \Exception("Unable to create product $name");
        }
    }

    public function delete($productId) {
        if (!$this->exists($productId)) {
            throw new \Exception("Product $productId does not exist");
        }

        $result = $this->db->prepare("DELETE FROM products WHERE id = ?");
        if (!$result->execute([$productId])) {
            throw new \Exception("Unable to delete product $productId");
        }
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

    public function changeStock($productId, $newQuantity) {
        if (!$this->exists($productId)) {
            throw new \Exception("Product $productId does not exist");
        }

        $result = $this->db->prepare("UPDATE products SET quantity = ? WHERE id = ?");
        if (!$result->execute([$newQuantity, $productId])) {
            throw new \Exception("Unable to update quantity of product $productId");
        }
    }
}