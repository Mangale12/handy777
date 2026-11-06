<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // The legacy chat tables were created with MySQL's
        // utf8mb4_general_ci default, while the Laravel forms table uses
        // utf8mb4_unicode_ci. Normalize the tables used in cross-table chat
        // lookups so comparisons work consistently.
        foreach (['forms', 'chat_sessions', 'chat_messages'] as $table) {
            if (Schema::hasTable($table)) {
                DB::statement(
                    "ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
                );
            }
        }
    }

    public function down()
    {
        // Keep the normalized collation on rollback; reverting to the legacy
        // mixed collations would restore the inbox error.
    }
};
