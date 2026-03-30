<?php

namespace App\Jobs;

use App\Services\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TranslateModelFields implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public int $tries = 3;

    public function __construct(
        protected string $modelClass,
        protected int $modelId,
        protected array $fields
    ) {}

    public function handle(TranslationService $translator): void
    {
        Log::info('Job started for: '.$this->modelClass.' ID: '.$this->modelId);

        $model = ($this->modelClass)::find($this->modelId);

        if (! $model) {
            Log::error('Model not found: '.$this->modelClass.' ID: '.$this->modelId);

            return;
        }

        $sourceLocale = config('app.locale', 'en');
        $targetLocales = array_filter(
            config('app.available_locales', []),
            fn ($locale) => $locale !== $sourceLocale
        );

        Log::info('Translating to locales: ', $targetLocales);

        foreach ($this->fields as $field => $text) {
            $translations = [];

            foreach ($targetLocales as $locale) {
                try {
                    $translated = $translator->translate($text, $locale, $sourceLocale);
                    $translations[$locale] = $translated;
                    Log::info("✅ Translated [{$field}] to [{$locale}]: {$translated}");
                } catch (\Exception $e) {
                    Log::error("❌ Failed [{$field}] to [{$locale}]: ".$e->getMessage());
                    $translations[$locale] = null;
                }
            }

            // ✅ Save translations into JSON column
            $model->setTranslations($field, $translations);
            Log::info("✅ Saved translations for field: {$field}");
        }

        Log::info('Job completed for model ID: '.$this->modelId);
    }
}
