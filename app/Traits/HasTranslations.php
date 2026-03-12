<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    // -----------------------------------------------
    // GET translation for a field
    // -----------------------------------------------
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? App::getLocale();
        $translations = $this->translations ?? [];

        // Return locale value if exists
        if (isset($translations[$field][$locale])) {
            return $translations[$field][$locale];
        }

        // Fallback to default locale
        $fallback = config('app.fallback_locale', 'en');
        if (isset($translations[$field][$fallback])) {
            return $translations[$field][$fallback];
        }

        // Final fallback: return raw DB column value
        return $this->attributes[$field] ?? null;
    }

    // -----------------------------------------------
    // SET single translation
    // -----------------------------------------------
    public function setTranslation(string $field, string $locale, string $value): self
    {
        $translations = $this->translations ?? [];
        $translations[$field][$locale] = $value;

        $this->translations = $translations;
        $this->save();

        return $this;
    }

    // -----------------------------------------------
    // SET multiple translations for a field
    // -----------------------------------------------
    public function setTranslations(string $field, array $localeValues): self
    {
        // ✅ Get existing translations from column
        $translations = $this->translations ?? [];

        foreach ($localeValues as $locale => $value) {
            if (! empty($value)) {
                $translations[$field][$locale] = $value;
            }
        }

        // ✅ Save back to translations column WITHOUT triggering observer again
        $this->translations = $translations;

        static::withoutEvents(function () {
            $this->save();
        });

        return $this;
    }

    // -----------------------------------------------
    // GET all translations for a field
    // -----------------------------------------------
    public function getTranslations(string $field): array
    {
        return $this->translations[$field] ?? [];
    }

    // -----------------------------------------------
    // CHECK if translation exists
    // -----------------------------------------------
    public function hasTranslation(string $field, string $locale): bool
    {
        return isset($this->translations[$field][$locale]);
    }

    // -----------------------------------------------
    // DELETE a specific translation
    // -----------------------------------------------
    public function forgetTranslation(string $field, string $locale): self
    {
        $translations = $this->translations ?? [];

        unset($translations[$field][$locale]);

        $this->translations = $translations;
        $this->save();

        return $this;
    }

    // -----------------------------------------------
    // MAGIC: $post->title auto returns current locale
    // -----------------------------------------------
    // public function getAttribute($key)
    // {
    //     if (
    //         isset($this->translatable) &&
    //         in_array($key, $this->translatable) &&
    //         $this->exists
    //     ) {
    //         return $this->getTranslation($key);
    //     }

    //     return parent::getAttribute($key);
    // }
    public function getAttribute($key)
    {
        if (
            isset($this->translatable) &&
            in_array($key, $this->translatable) &&
            $this->exists
        ) {
            // ✅ Get raw value from attributes first
            $rawValue = $this->attributes[$key] ?? null;

            // ✅ If no translations exist yet, return raw value
            $translations = $this->translations ?? [];
            if (empty($translations)) {
                return $rawValue;
            }

            return $this->getTranslation($key);
        }

        return parent::getAttribute($key);
    }

    // -----------------------------------------------
    // Cast translations column automatically
    // -----------------------------------------------
    public function initializeHasTranslations(): void
    {
        $this->casts['translations'] = 'array';
        $this->hidden[] = 'translations'; // ✅ adds to hidden automatically

    }

    public function toArray(): array
    {
        $array = parent::toArray();

        // Replace translatable fields with translated values
        foreach ($this->translatable ?? [] as $field) {
            if (isset($array[$field])) {
                $array[$field] = $this->getTranslation($field);
            }
        }

        // Remove translations column from all responses
        unset($array['translations']);

        return $array;
    }
}
