<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('chat_sessions')) {
            Schema::table('chat_sessions', function (Blueprint $table) {
                if (!Schema::hasColumn('chat_sessions', 'is_blocked')) {
                    $table->boolean('is_blocked')->default(false);
                }
                if (!Schema::hasColumn('chat_sessions', 'is_viewing')) {
                    $table->boolean('is_viewing')->default(false);
                }
                if (!Schema::hasColumn('chat_sessions', 'is_typing')) {
                    $table->boolean('is_typing')->default(false);
                }
                if (!Schema::hasColumn('chat_sessions', 'last_presence')) {
                    $table->timestamp('last_presence')->nullable();
                }
            });
        }

        if (Schema::hasTable('chat_messages') && !Schema::hasColumn('chat_messages', 'status')) {
            Schema::table('chat_messages', function (Blueprint $table) {
                $table->string('status', 20)->default('sent');
            });
        }

        if (Schema::hasTable('admin_users')) {
            Schema::table('admin_users', function (Blueprint $table) {
                if (!Schema::hasColumn('admin_users', 'last_activity')) {
                    $table->timestamp('last_activity')->nullable();
                }
                if (!Schema::hasColumn('admin_users', 'is_viewing')) {
                    $table->boolean('is_viewing')->default(false);
                }
                if (!Schema::hasColumn('admin_users', 'is_typing')) {
                    $table->boolean('is_typing')->default(false);
                }
                if (!Schema::hasColumn('admin_users', 'viewing_session_id')) {
                    $table->string('viewing_session_id', 64)->nullable();
                }
            });
        }
    }

    public function down()
    {
        // Keep compatibility columns in place so existing conversations are
        // never made unreadable by a rollback.
    }
};
