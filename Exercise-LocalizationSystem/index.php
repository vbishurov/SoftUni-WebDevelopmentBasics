<?php
require_once("templates/header.php");
require_once("translations.php");
?>

<header>
    <a href="?lang=bg">BG</a> | <a href="?lang=en">EN</a>

    <h1>
        <?= __('greetings_header_hello') ?>
    </h1>
</header>

<main id="content">
    <p>
        <?= __('welcome_message') ?>
    </p>
</main>

<?php
require_once("templates/footer.php");
?>
