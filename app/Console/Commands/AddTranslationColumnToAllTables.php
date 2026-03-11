<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTranslationColumnToAllTables extends Command
{
    protected $signature = 'translations:add-column';

    protected $description = 'Add translations JSON column to all tables';

    // ❌ Tables to SKIP (system tables)
    protected array $skipTables = [
        'migrations',
        'failed_jobs',
        'password_resets',
        'password_reset_tokens',
        'personal_access_tokens',
        'sessions',
        'cache',
        'cache_locks',
        'jobs',
        'job_batches',
    ];

    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $tableKey = "Tables_in_{$dbName}";

        $this->info('Starting to add translations column...');
        $bar = $this->output->createProgressBar(count($tables));

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            // Skip system tables
            if (in_array($tableName, $this->skipTables)) {
                $bar->advance();

                continue;
            }

            // Skip if column already exists
            if (Schema::hasColumn($tableName, 'translations')) {
                $this->line("  ⚠ Skipped (exists): {$tableName}");
                $bar->advance();

                continue;
            }

            try {
                Schema::table($tableName, function ($table) {
                    $table->json('translations')->nullable()->after('id');
                });
                $this->info("  ✅ Added: {$tableName}");
            } catch (\Exception $e) {
                $this->error("  ❌ Failed: {$tableName} - ".$e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Done! Translations column added to all tables.');
    }
}
