<?php

namespace App\Observers;

use App\Services\TranslationService;
use Illuminate\Database\Eloquent\Model;

class AutoTranslateObserver
{
    protected TranslationService $translator;

    public function __construct(TranslationService $translator)
    {
        $this->translator = $translator;
    }

    // ✅ Fires automatically on every CREATE
    public function created(Model $model): void
    {
        $this->translate($model);
    }

    // ✅ Fires automatically on every UPDATE
    public function updated(Model $model): void
    {
        // Only re-translate if translatable fields changed
        if ($model->wasChanged($model->translatable ?? [])) {
            $this->translate($model);
        }
    }

    private function translate(Model $model): void
    {
        if (empty($model->translatable)) {
            return;
        }

        // Build array of fields to translate
        $fieldsToTranslate = [];
        foreach ($model->translatable as $field) {
            if (! empty($model->$field)) {
                $fieldsToTranslate[$field] = $model->getRawOriginal($field) ?? $model->$field;
            }
        }

        if (empty($fieldsToTranslate)) {
            return;
        }

        // Auto translate all fields
        $translated = $this->translator->translateFields($fieldsToTranslate);

        // Save without triggering observer again
        foreach ($translated as $field => $locales) {
            $model->setTranslations($field, $locales);
        }
    }
}
