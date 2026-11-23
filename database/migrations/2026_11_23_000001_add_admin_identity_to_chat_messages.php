<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('chat_messages')) {
            return;
        }

        Schema::table('chat_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_messages', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('sender');
                $table->index('user_id');
            }

            if (!Schema::hasColumn('chat_messages', 'user_name')) {
                $table->string('user_name', 100)->nullable()->after('user_id');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('chat_messages')) {
            return;
        }

        Schema::table('chat_messages', function (Blueprint $table) {
            if (Schema::hasColumn('chat_messages', 'user_name')) {
                $table->dropColumn('user_name');
            }

            if (Schema::hasColumn('chat_messages', 'user_id')) {
                $table->dropIndex(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
