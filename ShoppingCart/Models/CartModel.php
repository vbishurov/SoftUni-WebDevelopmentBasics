<?php
namespace ShoppingCart\Models;

class CartModel extends Model
{
    public function add($shoppingCartId, $productId, $quantity) {
        $productAlreadyInCart = $this->db->prepare("SELECT product_id FROM shopping_carts WHERE id = ? AND product_id = ?");
        $productAlreadyInCart->execute([$shoppingCartId, $productId]);

        if ($productAlreadyInCart->rowCount() > 0) {
            $addToCart = $this->db->prepare("UPDATE shopping_carts SET quantity = quantity + ? WHERE id = ? AND product_id = ?");
            if (!$addToCart->execute([$quantity, $shoppingCartId, $productId])) {
                return false;
            }
        } else {
            $addToCart = $this->db->prepare("INSERT INTO shopping_carts (id, product_id, quantity) VALUES(?, ?, ?)");
            if (!$addToCart->execute([$shoppingCartId, $productId, $quantity])) {
                return false;
            }
        }

        $deductStock = $this->db->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
        if (!$deductStock->execute([$quantity, $productId])) {
            return false;
        }

        return true;
    }

    public function getInfo($id) {
        $result = $this->db->prepare("SELECT s.id AS shopping_cart_id, s.product_id, p.name, s.quantity, p.price FROM shopping_carts s
                                      INNER JOIN products p
                                      ON s.product_id = p.id
                                      WHERE s.id = ?");

        $result->execute([$id]);

        if ($result->rowCount() > 0) {
            return $result->fetchAll();
        }

        return array();
    }

    public function checkout($id) {
        $info = $this->getInfo($id);
        $totalCashNeeded = 0;

        foreach ($info as $product) {
            $totalCashNeeded += $product['quantity'] * $product['price'];
        }

        $result = $this->db->prepare("SELECT cash FROM users WHERE id = '$id'");
        $result->execute();
        $cashAvailable = intval($result->fetch()['cash']);

        if ($cashAvailable < $totalCashNeeded) {
            throw new \Exception("Insufficient funds");
        }

        if (empty($info)) {
            throw new \Exception("Shopping cart empty <a href=\"/products/all\">Add some products</a>");
        }

        $this->db->beginTransaction();

        $deductMoney = $this->db->prepare("UPDATE users SET cash = cash - ? WHERE id = ?");
        if (!$deductMoney->execute([$totalCashNeeded, $id])) {
            $this->db->rollback();
            throw new \Exception("Could not deduct money");
        }

        foreach ($info as $product) {
            $productId = $product['product_id'];
            $quantity = $product['quantity'];

            $userAlreadyPossesses = $this->db->prepare("SELECT product_id FROM user_possessions WHERE user_id = ? AND product_id = ?");
            $userAlreadyPossesses->execute([$id, $productId]);

            if ($userAlreadyPossesses->rowCount() > 0) {
                $addToPossessions = $this->db->prepare("UPDATE user_possessions SET quantity = quantity + ? WHERE product_id = ?");
                if (!$addToPossessions->execute([$quantity, $productId])) {
                    $this->db->rollback();
                    throw new \Exception("Could not add product $productId to possessions");
                }
            } else {
                $addToPossessions = $this->db->prepare("INSERT INTO user_possessions (user_id, product_id, quantity) VALUES (?, ?, ?)");
                if (!$addToPossessions->execute([$id, $productId, $quantity])) {
                    $this->db->rollback();
                    throw new \Exception("Could not add product $productId to possessions");
                }
            }

            $removeFromCart = $this->db->prepare("DELETE FROM shopping_carts WHERE id = ? AND product_id = ?");
            $removeFromCart->execute([$id, $productId]);
        }

        $this->db->commit();
    }
}