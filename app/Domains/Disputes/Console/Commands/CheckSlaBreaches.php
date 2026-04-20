<?php

namespace App\Domains\Disputes\Console\Commands;

use App\Domains\Disputes\Services\ComplaintClassificationService;
use App\Domains\Disputes\Services\SlaEscalationService;
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
        $this->info('Starting SLA check...');

        $classificationBreaches = app(ComplaintClassificationService::class)
            ->checkSlaBreaches();

        $slaResults = app(SlaEscalationService::class)
            ->checkBreaches();

        $this->info("Classification breaches: {$classificationBreaches}");
        $this->info("SLA breached: {$slaResults['breached']}");
        $this->info("SLA approaching: {$slaResults['approaching']}");

        $this->info('✅ SLA check finished');
    }
}
