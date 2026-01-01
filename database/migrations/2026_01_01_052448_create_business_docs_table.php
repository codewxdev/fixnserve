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
        Schema::create('business_docs', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('owner_name');
            $table->string('business_type');
            $table->string('location');
            $table->string('email');

            $table->string('tax_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('permit_number')->nullable();

            $table->string('permit_document')->nullable();
            $table->string('tax_certificate')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('other_licenses')->nullable();

            $table->unsignedBigInteger('user_id');        // who submitted
            $table->unsignedBigInteger('verified_by')->nullable(); // admin

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_docs');
    }
};
