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

    // ✅ Translate one text to all locales
    public function translateAll(string $text, string $sourceLocale = 'en'): array
    {
        $translations = [];

        foreach ($this->targetLocales as $locale) {
            try {
                $tr = new GoogleTranslate;
                $tr->setSource($sourceLocale);
                $tr->setTarget($locale);

                $translations[$locale] = $tr->translate($text);

            } catch (\Exception $e) {
                // If translation fails, skip that locale
                $translations[$locale] = null;
            }
        }

        return $translations;
    }

    // ✅ Translate multiple fields at once
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
