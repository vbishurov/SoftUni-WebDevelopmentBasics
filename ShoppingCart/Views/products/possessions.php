<?php
foreach ($model as $product) : ?>

    Name: <?= $product->getName() ?><br>
    In stock: <?= $product->getQuantity() ?><br>
    Price: $<?= $product->getPrice() ?><br>

    <a href="/products/sell/<?= $product->getId() ?>/1">Sell one</a> or <a href="/products/sell/<?= $product->getId() ?>/<?= $product->getQuantity() ?>">Sell all</a>
    <br><br>

<?php endforeach;
