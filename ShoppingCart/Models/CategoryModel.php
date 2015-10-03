<?php
namespace ShoppingCart\Models;

class CategoryModel extends Model
{
    public function add($name) {
        $result = $this->db->prepare("INSERT INTO categories (name) VALUES(?)");

        if (!$result->execute([$name])) {
            throw new \Exception("Could not add category $name");
        }
    }

    public function delete($id) {
        if (!$this->exists($id)) {
            throw new \Exception("Category $id does not exist");
        }

        $result = $this->db->prepare("DELETE FROM categories WHERE id = ?");

        if (!$result->execute([$id])) {
            throw new \Exception("Could not delete category $id");
        }
    }

    public function addToProduct($categoryId, $productId) {
        $result = $this->db->prepare("INSERT INTO products_categories (product_id, category_id) VALUES(?, ?)");

        if (!$result->execute([$productId,$categoryId])) {
            throw new \Exception("Could not add category $categoryId to product $productId");
        }
    }

    public function removeFromProduct($categoryId, $productId) {
        $result = $this->db->prepare("DELETE FROM products_categories WHERE product_id = ? AND category_id = ?");

        if (!$result->execute([$productId,$categoryId])) {
            throw new \Exception("Could not remove category $categoryId from product $productId");
        }
    }

    public function exists($id) {
        $result = $this->db->prepare("SELECT id FROM categories WHERE id = ?");
        $result->execute([$id]);

        return $result->rowCount() > 0;
    }
}