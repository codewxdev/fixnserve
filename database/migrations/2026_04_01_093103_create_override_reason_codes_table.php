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
        Schema::create('override_reason_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();      // EXCP-04, COMP-01
            $table->string('label');               // False Positive
            $table->enum('category', [
                'exception',
                'compliance',
                'operational',
                'legal',
            ]);
            $table->boolean('requires_dual_approval')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('override_reason_codes');
    }
};
