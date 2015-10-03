<?php
namespace ShoppingCart\ViewModels;

class ProductViewModel
{
    private $id;
    private $name;
    private $quantity;
    private $price;

    public function __construct($id, $name, $quantity, $price = null) {
     $this->setId($id)
         ->setName($name)
         ->setQuantity($quantity)
         ->setPrice($price);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }
}