<?php

namespace App\Observers;

use App\Jobs\TranslateModelFields;
use App\Services\TranslationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AutoTranslateObserver
{
    protected TranslationService $translator;

    public function __construct(TranslationService $translator)
    {
        $this->translator = $translator;
    }

    public function created(Model $model): void
    {
        Log::info('🔥 Observer fired for: '.get_class($model).' ID: '.$model->id);
        $this->dispatchTranslation($model);

        // $this->dispatchTranslation($model);
    }

    public function updated(Model $model): void
    {
        if ($model->wasChanged($model->translatable ?? [])) {
            $this->dispatchTranslation($model);
        }
    }

    private function dispatchTranslation(Model $model): void
    {
        if (empty($model->translatable)) {
            return;
        }

        // ✅ Fetch fresh model directly from DB — bypasses all trait issues
        $freshModel = $model->newQuery()->find($model->id);

        if (! $freshModel) {
            \Log::info('❌ Fresh model not found for ID: '.$model->id);

            return;
        }

        $fieldsToTranslate = [];
        foreach ($model->translatable as $field) {
            // ✅ Get raw value from fresh DB record
            $value = $freshModel->getRawOriginal($field);

            \Log::info("🔍 Field [{$field}] value: ".($value ?? 'NULL'));

            if (! empty($value)) {
                $fieldsToTranslate[$field] = $value;
            }
        }

        \Log::info('📝 Fields to translate: '.json_encode($fieldsToTranslate));

        if (empty($fieldsToTranslate)) {
            return;
        }

        TranslateModelFields::dispatch(
            get_class($model),
            $model->id,
            $fieldsToTranslate
        );

        \Log::info('✅ Job dispatched for ID: '.$model->id);
    }
}
