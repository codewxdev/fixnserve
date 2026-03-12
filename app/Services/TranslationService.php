<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    protected array $targetLocales;

    public function __construct()
    {
        // Define all languages you want to auto-translate to
        $this->targetLocales = ['ar', 'fr', 'es', 'de', 'ur'];
    }

    public function translate(string $text, string $targetLocale, string $sourceLocale = 'en'): ?string
    {
        $tr = new GoogleTranslate;
        $tr->setSource($sourceLocale);
        $tr->setTarget($targetLocale);

        return $tr->translate($text);
    }

    // ✅ Keep this same
    public function translateAll(string $text, string $sourceLocale = 'en'): array
    {
        $translations = [];

        foreach ($this->targetLocales as $locale) {
            try {
                $translations[$locale] = $this->translate($text, $locale, $sourceLocale); // ✅ now uses translate()
            } catch (\Exception $e) {
                $translations[$locale] = null;
            }
        }

        return $translations;
    }

    // ✅ Keep this same
    public function translateFields(array $fields, string $sourceLocale = 'en'): array
    {
        $result = [];

        foreach ($fields as $fieldName => $text) {
            if (! empty($text)) {
                $result[$fieldName] = $this->translateAll($text, $sourceLocale);
            }
        }

        return $result;
    }
}
