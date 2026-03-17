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
        Schema::table('configuration_snapshots', function (Blueprint $table) {
            // ✅ Drop old unique
            $table->dropUnique('configuration_snapshots_version_id_unique');

            // ✅ version_id + module combination unique honi chahiye
            $table->unique(['version_id', 'module'], 'snapshots_version_module_unique');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
