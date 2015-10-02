<?= $model->error ? $model->error : '' ;?>

<form action="<?= $_SERVER['REQUEST_URI'] == "/" ? "users/login" : "login"?>" method="post">
    <label for="username">Username: </label>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password: </label>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="Login"> Don't have an account? <a href="register">Register</a>
</form>