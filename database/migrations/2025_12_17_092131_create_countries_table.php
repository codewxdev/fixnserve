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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Pakistan
            $table->string('iso2', 2);            // PK
            $table->string('phone_code');         // +92
            $table->string('flag_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
        public function down(): void
        {
            // Schema::dropIfExists('countries');
        }
};
