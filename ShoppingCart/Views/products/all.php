<?php
foreach ($model as $product) : ?>

    <a class="product" href="/products/details/<?= $product->getId() ?>"><?= $product->getName() ?></a>

<?php endforeach;
