<?= $model->error ? $model->error : '' ;?>

<?php if ($model->success) : ?>
<?= $model->success; ?>
    <a href="/products/all">Shop some more</a>
<?php
endif;?>