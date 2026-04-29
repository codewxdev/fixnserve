<?php

namespace App\Domains\Config\Middlewares;

class LanguageMiddleware
{
    private static $supportedLanguages = ['en', 'ar', 'fr'];

    private static $defaultLanguage = 'en';

    private static $messages = [];

    private static $currentLanguage = 'en';

    public static function initialize()
    {
        self::$currentLanguage = self::detectLanguage();

        self::loadLanguageFile(self::$currentLanguage);

    }

    private static function detectLanguage()
    {

        // Check query parameter first
        if (isset($_GET['lang']) && in_array($_GET['lang'], self::$supportedLanguages)) {
            // dd($_GET['lang']);

            return $_GET['lang'];
        }

        // Check header
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($lang, self::$supportedLanguages)) {
                return $lang;
            }
        }

        return self::$defaultLanguage;
    }

    private static function loadLanguageFile($lang)
    {
        $filePath = __DIR__.'/../languages/'.$lang.'.json';

        if (file_exists($filePath)) {
            self::$messages = json_decode(file_get_contents($filePath), true);

            return self::$messages;
        }

        return null;
    }

    public static function getMessage($key)
    {
        return self::$messages[$key] ?? $key;
    }

    public static function getCurrentLanguage()
    {

        return self::$currentLanguage;
    }
}
