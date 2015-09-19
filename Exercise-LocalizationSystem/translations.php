<?php
require_once("Localization.php");

if (isset($_GET["lang"]) && !empty(trim($_GET["lang"]))) {
    $lang = $_GET["lang"];

    if ($lang !== Localization::LANG_EN && $lang !== Localization::LANG_BG) {
        throw new Exception("Language $lang is not supported");
    }

    setcookie("lang", $lang);
    $_COOKIE["lang"] = $lang;
}

function __($tag) {
    $lang = isset($_COOKIE["lang"]) && !empty(trim($_COOKIE["lang"])) ? $_COOKIE["lang"] : Localization::DEFAULT_LANG;

    return Localization::$string[$tag][$lang];
}