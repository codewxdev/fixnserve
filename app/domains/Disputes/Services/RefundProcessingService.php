<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundProcessingService
{
    // ✅ Process approved refund
    public function process(RefundRequest $refund): RefundRequest
    {

        $refund->update(['status' => 'processing']);

        try {
            DB::transaction(function () use ($refund) {
                // dd($refund->refund_type);
                match ($refund->refund_type) {
                    'wallet' => $this->processWalletRefund($refund),
                    'original_payment_method' => $this->processPspRefund($refund),
                    'store_credit' => $this->processStoreCredit($refund),
                    'cod_adjustment' => $this->processCodAdjustment($refund),
                };

                $refund->update([
                    'status' => 'completed',
                    'processed_at' => now(),
                ]);

                Log::info("✅ Refund processed: {$refund->refund_id}");
            });

        } catch (\Exception $e) {
            $refund->update([
                'status' => 'failed',
                'psp_status' => substr($e->getMessage(), 0, 255),
            ]);
            Log::error("❌ Refund failed: {$refund->refund_id} - ".$e->getMessage());
            throw $e;
        }

        return $refund->fresh();
    }

    // ✅ Wallet Refund
    private function processWalletRefund(RefundRequest $refund): void
    {
        // dd($refund);
        DB::table('wallet_transactions')->insert([
            'user_id' => $refund->entity_id,
            'type' => 'refund',
            'amount' => $refund->approved_amount,
            'wallet_id' => $refund->wallet_id, // <- add this

            'reference_id' => $refund->refund_id,
            'description' => "Refund for {$refund->order_ref}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("💳 Wallet credited: Rs.{$refund->approved_amount} to user {$refund->entity_id}");
    }

    // ✅ PSP Refund (Original Payment Method)
    private function processPspRefund(RefundRequest $refund): void
    {
        // Call PSP API
        // Mock for now
        $pspTransactionId = 'PSP-'.now()->timestamp.'-'.$refund->id;

        $refund->update([
            'psp_transaction_id' => $pspTransactionId,
            'psp_status' => 'submitted',
        ]);

        Log::info("🏦 PSP refund submitted: {$pspTransactionId}");
    }

    // ✅ Store Credit
    private function processStoreCredit(RefundRequest $refund): void
    {
        DB::table('store_credits')->insert([
            'user_id' => $refund->entity_id,
            'amount' => $refund->approved_amount,
            'reference' => $refund->refund_id,
            'expires_at' => now()->addDays(90),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("🎫 Store credit added: Rs.{$refund->approved_amount}");
    }

    // ✅ COD Adjustment
    private function processCodAdjustment(RefundRequest $refund): void
    {
        DB::table('cod_adjustments')->insert([
            'order_ref' => $refund->order_ref,
            'amount' => $refund->approved_amount,
            'reference' => $refund->refund_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("💵 COD adjusted: Rs.{$refund->approved_amount}");
    }
}
