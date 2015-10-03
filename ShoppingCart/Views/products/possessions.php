<?php
foreach ($model as $product) : ?>

    Name: <?= $product->getName() ?><br>
    In stock: <?= $product->getQuantity() ?><br>
    Price: $<?= $product->getPrice() ?><br><br>

    <a href="/product/sell/<?= $product->getId() ?>">Sell one</a> or <a href="/product/sell/<?= $product->getId() ?>/id">Sell all</a>

<?php endforeach;
