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
        Schema::create('temporary_overrides', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ip', 'user', 'api_key']);
            $table->string('value');           // IP address, user_id, api_key
            $table->integer('limit');          // custom limit
            $table->string('reason')->nullable();
            $table->timestamp('expires_at');   // temporary duration
            $table->boolean('is_blocked')->default(false); // complete block
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_overrides');
    }
};
