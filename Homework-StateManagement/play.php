<?php
session_start();

if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
    $username = $_POST['username'];

    $_SESSION['username'] = $username;
    $_SESSION['randomNumber'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
} else if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    var_dump($_SESSION);
}

if (isset($_POST['number']) && $_POST['number'] == $_SESSION['randomNumber']):
    session_destroy();
    ?>

    <h1>Congratulations! You have guessed the number in <?= ++$_SESSION['attempts'] ?> attempts</h1>

    <p>Care for another game? <a href="index.php">Click here</a></p>

    <?php
else: ?>

    <form action="play.php" method="post">
        <label for="number">Pick a number: </label>
        <input type="text" id="number" name="number">

        <input type="submit" value="Guess!">
    </form>

    <?php
    if (isset($_POST['number'])):
        $_SESSION['attempts']++;
        ?>

        <p>
            Your number is <?= $_POST['number'] < $_SESSION['randomNumber'] ? 'smaller' : 'bigger' ?> than the generated
            number. Please try again.
        </p>

        <?php
    endif;
endif;