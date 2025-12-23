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
        Schema::table('user_payments', function (Blueprint $table) {
            $table->string('address_line')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('currency')->nullable()->default('USD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_payments', function (Blueprint $table) {
            //
        });
    }
};
