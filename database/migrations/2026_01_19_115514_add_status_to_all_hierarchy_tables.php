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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'active')) {
                $table->boolean('active')->default(true)->after('name');
            }
        });

        // Subcategory Table
        Schema::table('subcategories', function (Blueprint $table) {
            if (!Schema::hasColumn('subcategories', 'active')) {
                $table->boolean('active')->default(true)->after('name');
            }
        });

        // Specialty Table
        Schema::table('specialties', function (Blueprint $table) {
            if (!Schema::hasColumn('specialties', 'active')) {
                $table->boolean('active')->default(true)->after('name');
            }
        });

        // Sub-specialty Table
        Schema::table('sub_specialties', function (Blueprint $table) {
            if (!Schema::hasColumn('sub_specialties', 'active')) {
                $table->boolean('active')->default(true)->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('active');
        });
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn('active');
        });
        Schema::table('specialties', function (Blueprint $table) {
            $table->dropColumn('active');
        });
        Schema::table('sub_specialties', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
