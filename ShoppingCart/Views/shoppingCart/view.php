<?php
if (empty($model)) : ?>
    No products in cart. <a href="/products/all">Add some</a>
<?php
exit;
endif;

$total = 0;
foreach ($model as $entry) :
    $total += $entry['quantity'] * $entry['price'];
    ?>

    <div class="entry">
        <?= $entry['name'] ?>, Quantity: <?= $entry['quantity'] ?>, Price: $<?= $entry['price'] ?>
    </div>

    <?php
endforeach; ?>

<span class="pull-right"><strong>Total: $<?= $total ?></strong></span>

<a href="/products/all">Continue shopping</a> or

<a href="/shoppingcart/checkout">Checkout</a>
