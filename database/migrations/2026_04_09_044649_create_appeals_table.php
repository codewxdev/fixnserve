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
        // ✅ 1. Appeals Table
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->string('appeal_id')->unique();     // APP-2024-001

            // What are they appealing
            $table->enum('appeal_type', [
                'rejected_complaint',
                'partial_refund',
                'account_action',
                'rejected_refund',
            ]);

            // Links
            $table->foreignId('complaint_id')
                ->nullable()
                ->constrained('complaints');
            $table->foreignId('refund_request_id')
                ->nullable()
                ->constrained('refund_requests');

            // Appellant
            $table->string('appellant_type');          // customer, provider
            $table->unsignedBigInteger('appellant_id');
            $table->string('appellant_ref');           // C-199

            // Appeal Details
            $table->text('appeal_reason');
            $table->json('new_evidence')->nullable();  // uploaded files/links
            $table->decimal('requested_amount', 12, 2)->nullable();

            // Window & Limits
            $table->timestamp('submission_deadline')->nullable();
            $table->boolean('within_window')->default(true);

            // Review
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();

            // Decision
            $table->enum('status', [
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'partial_approved',
                'locked',
            ])->default('submitted');

            $table->enum('final_decision', [
                'pending',
                'upheld',        // original decision correct
                'overturned',    // user wins
                'partial',       // compromise
            ])->default('pending');

            $table->decimal('awarded_amount', 12, 2)->default(0);
            $table->boolean('is_final')->default(false); // locked - no more appeals
            $table->timestamp('locked_at')->nullable();

            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['appellant_type', 'appellant_id']);
            $table->index('status');
            $table->index('appeal_type');
        });

        // ✅ 2. Appeal Policies
        Schema::create('appeal_policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_key')->unique();
            $table->integer('max_appeals_per_user');      // 3 per month
            $table->integer('appeal_window_days');         // 7 days to appeal
            $table->integer('cooldown_hours');             // 24h between appeals
            $table->integer('review_sla_hours');           // 48h to review
            $table->boolean('require_new_evidence')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 3. Appeal Evidence
        Schema::create('appeal_evidences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appeal_id')->constrained('appeals');
            $table->string('evidence_type');              // photo, video, document, chat
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->text('description')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
