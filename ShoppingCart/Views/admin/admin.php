<?php
if (isset($_POST['addCategory']) && isset($_POST['addCategoryName'])) {
    $categoryName = $_POST['addCategoryName'];
    header("Location: /categories/add/$categoryName");
}

if (isset($_POST['deleteCategory']) && isset($_POST['deleteCategoryId'])) {
    $categoryId = $_POST['deleteCategoryId'];
    header("Location: /categories/delete/$categoryId");
}

if (isset($_POST['addCategoryToProduct']) && isset($_POST['addCategoryIdToProduct']) && isset($_POST['addCategoryToProductId'])) {
    $categoryId = $_POST['addCategoryIdToProduct'];
    $productId = $_POST['addCategoryToProductId'];
    header("Location: /categories/addToProduct/$categoryId/$productId");
}

if (isset($_POST['deleteCategoryFromProduct']) && isset($_POST['deleteCategoryIdFromProduct']) && isset($_POST['deleteCategoryFromProductId'])) {
    $categoryId = $_POST['deleteCategoryIdFromProduct'];
    $productId = $_POST['deleteCategoryFromProductId'];
    header("Location: /categories/removeFromProduct/$categoryId/$productId");
}

if (isset($_POST['addProduct']) && isset($_POST['addProductName']) && isset($_POST['addProductQuantity']) && isset($_POST['addProductPrice'])) {
    $name = $_POST['addProductName'];
    $quantity = $_POST['addProductQuantity'];
    $price = $_POST['addProductPrice'];
    header("Location: /products/add/$name/$quantity/$price");
}

if (isset($_POST['deleteProduct']) && isset($_POST['deleteProductId'])) {
    $productId = $_POST['deleteProductId'];
    header("Location: /products/delete/$productId");
}

if (isset($_POST['changeQuantity']) && isset($_POST['changeQuantityProductId']) && isset($_POST['changeQuantityNewQuantity'])) {
    $productId = $_POST['changeQuantityProductId'];
    $newQuantity = $_POST['changeQuantityNewQuantity'];
    header("Location: /products/changeStock/$productId/$newQuantity");
}
?>

<form action="" method="post">
    <h3>Add Category</h3>
    <label for="addCategoryName">Name: </label>
    <input type="text" id="addCategoryName" name="addCategoryName">
    <input type="submit" value="Add category" name="addCategory">
</form>

<form action="" method="post">
    <h3>Delete Category</h3>
    <label for="deleteCategoryId">Category Id: </label>
    <input type="text" id="deleteCategoryId" name="deleteCategoryId">
    <input type="submit" value="Delete category" name="deleteCategory">
</form>

<form action="" method="post">
    <h3>Add Category to product</h3>
    <label for="addCategoryIdToProduct">Category Id: </label>
    <input id="addCategoryIdToProduct" name="addCategoryIdToProduct" type="text">
    <label for="addCategoryToProductId">Product Id: </label>
    <input id="addCategoryToProductId" name="addCategoryToProductId" type="text">
    <input type="submit" value="Add category to product" name="addCategoryToProduct">
</form>

<form action="" method="post">
    <h3>Remove Category From product</h3>
    <label for="deleteCategoryIdFromProduct">Category Id: </label>
    <input id="deleteCategoryIdFromProduct" name="deleteCategoryIdFromProduct" type="text">
    <label for="deleteCategoryFromProductId">Product Id: </label>
    <input id="deleteCategoryFromProductId" name="deleteCategoryFromProductId" type="text">
    <input type="submit" value="Remove category From product" name="deleteCategoryFromProduct">
</form>

<form action="" method="post">
    <h3>Add product</h3>
    <label for="addProductName">Name: </label>
    <input type="text" id="addProductName" name="addProductName">
    <label for="addProductQuantity">Quantity: </label>
    <input type="text" id="addProductQuantity" name="addProductQuantity">
    <label for="addProductPrice">Price: </label>
    <input type="text" id="addProductPrice" name="addProductPrice">
    <input type="submit" value="Add product" name="addProduct">
</form>

<form action="" method="post">
    <h3>Delete product</h3>
    <label for="deleteProductId">Product Id: </label>
    <input type="text" name="deleteProductId" id="deleteProductId">
    <input type="submit" value="Delete product" name="deleteProduct">
</form>

<form action="" method="post">
    <h3>Change product quantity</h3>
    <label for="changeQuantityProductId">Product Id: </label>
    <input type="text" name="changeQuantityProductId" id="changeQuantityProductId">
    <label for="changeQuantityNewQuantity">New quantity: </label>
    <input type="text" name="changeQuantityNewQuantity" id="changeQuantityNewQuantity">
    <input type="submit" value="Change quantity" name="changeQuantity">
</form>