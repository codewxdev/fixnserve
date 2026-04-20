<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('security_audit_logs', function (Blueprint $table) {
             $table->string('session_id')->nullable()->after('device'); 
        });
    }

    public function down()
    {
        Schema::table('security_audit_logs', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};
