<?= $model->error ? $model->error : '' ;?>

<form action="" method="post">
    <label for="username">Username: </label>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password: </label>
    <input type="password" id="password" name="password"><br>
    <label for="firstName">First name: </label>
    <input type="text" id="firstName" name="firstName"><br>
    <label for="lastName">Last name: </label>
    <input type="text" id="lastName" name="lastName"><br>
    <input type="submit" value="Register"> Already registered? <a href="login">Login</a>
</form>