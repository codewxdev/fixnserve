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
        Schema::table('consultant_bookings', function (Blueprint $table) {
            $table->smallInteger('duration')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultant_bookings', function (Blueprint $table) {
            $table->enum('duration', ['15', '30', '45', '60'])->change();
        });
    }
};
