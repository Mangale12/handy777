<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('chat_sessions') && !Schema::hasColumn('chat_sessions', 'ip_address')) {
            Schema::table('chat_sessions', function (Blueprint $table) {
                $table->string('ip_address', 45)->nullable()->after('browser_fp');
            });
        }
    }

    public function down()
    {
        // The column is part of the base chat schema, so it must remain when
        // this compatibility migration is rolled back.
    }
};
