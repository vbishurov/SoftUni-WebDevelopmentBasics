<?php

class Localization
{
    const LANG_EN = "en";
    const LANG_BG = "bg";

    const DEFAULT_LANG = self::LANG_EN;

    public static $string = [
        "greetings_header_hello" => [
            self::LANG_EN => "Hello",
            self::LANG_BG => "Здравейте"
        ],
        "informal_hello" => [
            self::LANG_EN => "Hello",
            self::LANG_BG => "Здрасти"
        ],
        "welcome_message" => [
            self::LANG_EN => "Welcome to our site!",
            self::LANG_BG => "Добре дощли в нашия сайт!"
        ]
    ];
}