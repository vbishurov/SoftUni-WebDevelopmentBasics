<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\View;

class AdminController extends Controller
{
    public function admin() {
        return new View();
    }
}