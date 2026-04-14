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
        // ✅ 1. Legal Cases
        Schema::create('legal_cases', function (Blueprint $table) {
            $table->id();
            $table->string('legal_case_id')->unique();   // LC-2024-001
            $table->string('related_type');               // complaint, appeal, refund
            $table->unsignedBigInteger('related_id');
            $table->string('case_ref');                   // CASE-2024-001
            $table->enum('case_type', [
                'regulatory_audit',
                'court_case',
                'internal_review',
                'compliance_check',
                'fraud_investigation',
            ]);
            $table->enum('status', [
                'open',
                'under_legal_hold',
                'sealed',
                'exported',
                'archived',
                'closed',
            ])->default('open');
            $table->boolean('is_sealed')->default(false);
            $table->boolean('legal_hold')->default(false);
            $table->timestamp('sealed_at')->nullable();
            $table->timestamp('hold_placed_at')->nullable();
            $table->timestamp('hold_expires_at')->nullable();
            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users');
            $table->text('legal_notes')->nullable();
            $table->string('regulator_ref')->nullable();  // External reference
            $table->json('meta')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['related_type', 'related_id']);
            $table->index('status');
            $table->index('legal_hold');
        });

        // ✅ 2. Legal Holds
        Schema::create('legal_holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legal_case_id')
                ->constrained('legal_cases');
            $table->string('hold_type');                  // data, account, wallet
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');
            $table->text('reason');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('placed_by')
                ->constrained('users');
            $table->foreignId('lifted_by')
                ->nullable()
                ->constrained('users');
            $table->timestamp('lifted_at')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('is_active');
        });

        // ✅ 3. Compliance Exports
        Schema::create('compliance_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legal_case_id')
                ->constrained('legal_cases');
            $table->enum('export_type', [
                'case_bundle',
                'evidence_bundle',
                'regulatory_report',
                'audit_trail',
                'full_case_export',
            ]);
            $table->string('export_format');              // PDF, CSV, JSON, ZIP
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('checksum')->nullable();       // SHA256 for integrity
            $table->foreignId('generated_by')
                ->constrained('users');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_encrypted')->default(false);
            $table->json('included_sections')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 4. Legal Audit Trail (Immutable)
        Schema::create('legal_audit_trail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legal_case_id')
                ->constrained('legal_cases');
            $table->foreignId('actor_id')
                ->constrained('users');
            $table->string('action');
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->json('snapshot')->nullable();
            $table->json('translations')->nullable();
            $table->timestamp('created_at');

            // Immutable - no updated_at
            $table->index('legal_case_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_compliance');
    }
};
