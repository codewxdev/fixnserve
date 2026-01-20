<?php

namespace App\Console\Commands;

use App\Models\PromotionPurchase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpirePromotionPurchases extends Command
{
    protected $signature = 'promotions:expire';

    protected $description = 'Expire active promotion purchases whose time has ended';

    public function handle(): int
    {
        DB::transaction(function () {

            $expired = PromotionPurchase::where('is_active', true)
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', now())
                ->lockForUpdate()
                ->get();

            foreach ($expired as $purchase) {

                // 🔴 Deactivate purchase
                $purchase->update([
                    'is_active' => false,
                ]);

                // OPTIONAL: free slot if your logic needs it
                // $purchase->slot->decrement('used_slots');
            }
        });

        $this->info('Expired promotions processed successfully.');

        return Command::SUCCESS;
    }
}
