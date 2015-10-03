<?php echo  isset($model->error) && $model->error ? $model->error : '';
if (isset($model->error) && $model->error) {
    exit();
}
?>

Name: <?= $model->getName() ?><br>
In stock: <?= $model->getQuantity() ?><br>
Price: $<?= $model->getPrice() ?><br><br>

<form action="/shoppingcart/add" method="post">
    <input type="hidden" name="id" value="<?= $model->getId() ?>">
    <label for="quantity">Quantity: </label>
    <input type="text" id="quantity" pattern="^(?=[1-9])[0-9]+$" title="Positive number" name="quantity">
    <input type="submit" value="Add to cart">
</form>
