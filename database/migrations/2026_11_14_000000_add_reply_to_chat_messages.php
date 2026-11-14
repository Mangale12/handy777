<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('chat_messages') && !Schema::hasColumn('chat_messages', 'reply_to_id')) {
            Schema::table('chat_messages', function (Blueprint $table) {
                // Do not add a foreign key here: these tables are also used by
                // the legacy PHP chat and may have been created without one.
                $table->unsignedBigInteger('reply_to_id')->nullable()->after('file_name');
                $table->index('reply_to_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('chat_messages') && Schema::hasColumn('chat_messages', 'reply_to_id')) {
            Schema::table('chat_messages', function (Blueprint $table) {
                $table->dropIndex(['reply_to_id']);
                $table->dropColumn('reply_to_id');
            });
        }
    }
};
