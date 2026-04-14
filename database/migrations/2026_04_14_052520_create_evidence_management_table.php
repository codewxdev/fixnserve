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
        // ✅ 1. Case Evidences
        Schema::create('case_evidences', function (Blueprint $table) {
            $table->id();
            $table->string('evidence_id')->unique();      // EVD-2024-001
            $table->string('case_type');                  // complaint, appeal
            $table->unsignedBigInteger('case_id');
            $table->string('case_ref');

            $table->enum('evidence_type', [
                'chat_transcript',
                'call_log',
                'delivery_proof',
                'gps_trace',
                'timestamp_log',
                'transaction_log',
                'photo',
                'video',
                'document',
                'otp_verification',
                'system_log',
            ]);

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->json('content')->nullable();           // For structured data
            $table->string('checksum')->nullable();        // Integrity check
            $table->timestamp('event_timestamp')->nullable(); // When event occurred

            // Context Links
            $table->unsignedBigInteger('linked_order_id')->nullable();
            $table->unsignedBigInteger('linked_user_id')->nullable();
            $table->unsignedBigInteger('linked_wallet_tx_id')->nullable();

            // Status
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_tampered')->default(false);
            $table->boolean('is_shared')->default(false);
            $table->timestamp('locked_at')->nullable();

            $table->foreignId('uploaded_by')
                ->constrained('users');
            $table->foreignId('locked_by')
                ->nullable()->constrained('users');

            $table->json('meta')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['case_type', 'case_id']);
            $table->index('evidence_type');
            $table->index('is_locked');
            $table->index('event_timestamp');
        });

        // ✅ 2. Evidence Timeline
        Schema::create('evidence_timelines', function (Blueprint $table) {
            $table->id();
            $table->string('case_type');
            $table->unsignedBigInteger('case_id');
            $table->string('case_ref');
            $table->foreignId('evidence_id')
                ->constrained('case_evidences');
            $table->timestamp('event_time');
            $table->string('event_type');
            $table->text('event_description');
            $table->string('actor_ref')->nullable();      // Who did it
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['case_type', 'case_id']);
            $table->index('event_time');
        });

        // ✅ 3. Evidence Shares
        Schema::create('evidence_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidence_id')
                ->constrained('case_evidences');
            $table->foreignId('shared_by')
                ->constrained('users');
            $table->foreignId('shared_with')
                ->constrained('users');
            $table->string('department');                  // legal, finance, ops
            $table->text('share_reason')->nullable();
            $table->boolean('can_download')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidence_management');
    }
};
