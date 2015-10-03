<?php
namespace ShoppingCart\Controllers;

use ShoppingCart\Models\CategoryModel;
use ShoppingCart\View;
use ShoppingCart\ViewModels\InformationViewModel;

class CategoriesController extends Controller
{
    public function add($name) {
        $this->validatePermissions();

        $categoryModel = new CategoryModel();
        $viewModel = new InformationViewModel();

        try {
            $categoryModel->add($name);

            $viewModel->success = "Category $name added successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }

    public function delete($id) {
        $this->validatePermissions();

        $categoryModel = new CategoryModel();
        $viewModel = new InformationViewModel();

        try {
            $categoryModel->delete($id);

            $viewModel->success = "Category $id deleted successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }

    public function addToProduct($categoryId, $productId) {
        $this->validatePermissions();

        $categoryModel = new CategoryModel();
        $viewModel = new InformationViewModel();

        try {
            $categoryModel->addToProduct($categoryId, $productId);

            $viewModel->success = "Category $categoryId added to product $productId successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }

    public function removeFromProduct($categoryId, $productId) {
        $this->validatePermissions();

        $categoryModel = new CategoryModel();
        $viewModel = new InformationViewModel();

        try {
            $categoryModel->removeFromProduct($categoryId, $productId);

            $viewModel->success = "Category $categoryId removed from product $productId successfully";
        } catch(\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        return new View($viewModel);
    }
}