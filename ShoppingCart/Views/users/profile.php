<h1>Hello, <?= $model->getFirstName(); ?> <?= $model->getLastName(); ?> (<?= $model->getUsername(); ?>)</h1>
<h3>
    <p>Cash: <?= $model->getCash(); ?></p>
</h3>

<?php if(isset($_GET['error'])): ?>
    <h2>An error occurred</h2>
<?php elseif(isset($_GET['success'])): ?>
    <h2>Successfully updated profile</h2>
<?php endif; ?>


<form method="post">
    <div>
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" value="<?=$model->getUsername();?>" /><br>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" /><br>
        <label for="confirm">Confirm password: </label>
        <input type="password" id="confirm" name="confirm" /><br>
        <input type="submit" name="edit" value="Edit" />
        <a href="logout">Logout</a>
    </div>
</form>

<a href="/products/all">View available products</a>