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
        Schema::table('security_audit_logs', function (Blueprint $table) {

            if (! Schema::hasColumn('security_audit_logs', 'log_id')) {
                $table->string('log_id')->nullable()->after('id');
            }
            if (! Schema::hasColumn('security_audit_logs', 'user_ref')) {
                $table->string('user_ref')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('security_audit_logs', 'user_role')) {
                $table->string('user_role')->nullable()->after('user_ref');
            }
            if (! Schema::hasColumn('security_audit_logs', 'success')) {
                $table->boolean('success')->default(true)->after('is_anomaly');
            }
            if (! Schema::hasColumn('security_audit_logs', 'failure_reason')) {
                $table->text('failure_reason')->nullable()->after('success');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('security_audit_logs', function (Blueprint $table) {
            //
        });
    }
};
