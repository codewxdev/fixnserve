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
        Schema::table('countries', function (Blueprint $table) {
            $table->string('default_language')->default('en');

            $table->string('currency_code')->nullable();

            $table->string('date_format')->default('d-m-Y');

            $table->string('time_format')->default('H:i');

            $table->string('decimal_separator')->default('.');

            $table->string('thousand_separator')->default(',');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            //
        });
    }
};
