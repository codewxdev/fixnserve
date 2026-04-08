<?php

namespace App\Domains\Disputes\Console\Commands;

use App\Domains\Disputes\Services\ComplaintClassificationService;
use Illuminate\Console\Command;

class CheckSlaBreaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-sla-breaches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $breached = app(ComplaintClassificationService::class)
            ->checkSlaBreaches();

        $this->info("✅ SLA check complete. Breached: {$breached}");
    }
}
