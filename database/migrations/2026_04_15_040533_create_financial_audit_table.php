<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ✅ 1. Financial Ledger (Immutable)
        Schema::create('financial_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('ledger_id')->unique();         // LDG-2024-000001
            $table->string('transaction_ref')->nullable(); // TXN-456, REF-2024-001

            // Entity
            $table->string('entity_type');                // customer, rider, vendor
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');                 // C-199, R-50

            // Financial Details
            $table->enum('entry_type', [
                'wallet_credit',
                'wallet_debit',
                'payout',
                'refund',
                'chargeback',
                'adjustment',
                'cod_collection',
                'cod_deposit',
                'commission',
                'commission_deduction',
                'penalty',
                'bonus',
                'tax',
            ]);

            $table->decimal('amount', 14, 2);
            $table->decimal('balance_before', 14, 2)->default(0);
            $table->decimal('balance_after', 14, 2)->default(0);
            $table->string('currency', 3)->default('PKR');

            // Cross-module Links
            $table->string('source_module')->nullable();   // order, refund, appeal
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('source_ref')->nullable();      // ORD-1092, REF-2024-001

            // Order link
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('order_ref')->nullable();

            // Commission
            $table->decimal('commission_rate', 5, 2)->nullable();
            $table->decimal('commission_amount', 14, 2)->nullable();
            $table->decimal('tax_amount', 14, 2)->nullable();

            // Status
            $table->enum('status', [
                'posted',
                'pending',
                'reversed',
                'disputed',
                'reconciled',
            ])->default('posted');

            $table->string('description')->nullable();
            $table->string('initiated_by')->nullable();   // system, admin, user
            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users');

            // Immutable checksum
            $table->string('checksum')->nullable();
            $table->boolean('is_reconciled')->default(false);
            $table->json('meta')->nullable();
            $table->json('translations')->nullable();

            // Immutable timestamps
            $table->timestamp('posted_at');
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('entry_type');
            $table->index('status');
            $table->index('posted_at');
            $table->index('order_id');
            $table->index('source_module');
        });

        // ✅ 2. Reconciliation Snapshots
        Schema::create('reconciliation_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('snapshot_id')->unique();      // SNAP-2024-001
            $table->enum('snapshot_type', [
                'daily',
                'weekly',
                'monthly',
                'on_demand',
            ]);
            $table->date('period_from');
            $table->date('period_to');
            $table->string('entity_type')->nullable();    // null = all entities
            $table->unsignedBigInteger('entity_id')->nullable();

            // Totals
            $table->decimal('total_credits', 14, 2)->default(0);
            $table->decimal('total_debits', 14, 2)->default(0);
            $table->decimal('total_payouts', 14, 2)->default(0);
            $table->decimal('total_refunds', 14, 2)->default(0);
            $table->decimal('total_chargebacks', 14, 2)->default(0);
            $table->decimal('total_commission', 14, 2)->default(0);
            $table->decimal('total_cod', 14, 2)->default(0);
            $table->decimal('net_balance', 14, 2)->default(0);
            $table->decimal('expected_balance', 14, 2)->default(0);
            $table->decimal('variance', 14, 2)->default(0);

            // Status
            $table->enum('status', [
                'pending',
                'matched',
                'variance_found',
                'investigating',
                'resolved',
            ])->default('pending');

            $table->integer('total_transactions')->default(0);
            $table->integer('unreconciled_count')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('generated_by')
                ->constrained('users');
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->string('checksum')->nullable();
            $table->json('breakdown')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('snapshot_type');
            $table->index('status');
            $table->index('period_from');
        });

        // ✅ 3. COD Reconciliation
        Schema::create('cod_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->string('cod_ref')->unique();           // COD-2024-001
            $table->unsignedBigInteger('rider_id');
            $table->string('rider_ref');
            $table->unsignedBigInteger('order_id');
            $table->string('order_ref');
            $table->decimal('collected_amount', 12, 2);
            $table->decimal('expected_amount', 12, 2);
            $table->decimal('variance', 12, 2)->default(0);
            $table->enum('status', [
                'pending',
                'deposited',
                'late',
                'variance_found',
                'reconciled',
                'disputed',
            ])->default('pending');
            $table->timestamp('collected_at')->nullable();
            $table->timestamp('deposited_at')->nullable();
            $table->timestamp('due_at')->nullable();       // 48h deadline
            $table->boolean('is_overdue')->default(false);
            $table->text('notes')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('rider_id');
            $table->index('status');
            $table->index('is_overdue');
        });

        // ✅ 4. Commission Ledger
        Schema::create('commission_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('commission_ref')->unique();
            $table->unsignedBigInteger('order_id');
            $table->string('order_ref');
            $table->string('entity_type');               // vendor, provider, rider
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');
            $table->decimal('order_amount', 12, 2);
            $table->decimal('commission_rate', 5, 2);
            $table->decimal('commission_amount', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('net_payout', 12, 2);
            $table->enum('status', [
                'calculated',
                'approved',
                'paid',
                'disputed',
                'adjusted',
            ])->default('calculated');
            $table->foreignId('ledger_id')
                ->nullable()
                ->constrained('financial_ledger');
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('status');
            $table->index('order_id');
        });

        // ✅ 5. Audit Flags (Suspicious entries)
        Schema::create('financial_audit_flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')
                ->constrained('financial_ledger');
            $table->enum('flag_type', [
                'duplicate',
                'amount_mismatch',
                'missing_reference',
                'unauthorized',
                'timing_anomaly',
                'balance_mismatch',
            ]);
            $table->text('description');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])
                ->default('medium');
            $table->enum('status', ['open', 'investigating', 'resolved', 'dismissed'])
                ->default('open');
            $table->foreignId('flagged_by')
                ->nullable()
                ->constrained('users');
            $table->foreignId('resolved_by')
                ->nullable()
                ->constrained('users');
            $table->timestamp('resolved_at')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('flag_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_audit');
    }
};
