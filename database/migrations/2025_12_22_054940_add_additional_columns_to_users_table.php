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
        Schema::table('users', function (Blueprint $table) {
            // Location columns
            $table->decimal('lat', 10, 8)->nullable()->after('email');
            $table->decimal('lon', 11, 8)->nullable()->after('lat');

            $table->enum('phone_status', ['verified', 'not_verified'])->default('not_verified')->after('country_flag');

            // Add index for better performance on frequently queried columns
            $table->index('phone_status');
            $table->index('rating');
            $table->index('favourite');
            $table->index(['lat', 'lon']); // Composite index for location queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
