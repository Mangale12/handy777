<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('chat_sessions')) {
            Schema::create('chat_sessions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('session_id', 64)->unique();
                $table->string('visitor_name', 100)->default('Visitor');
                $table->string('visitor_email', 150)->nullable();
                $table->string('browser_fp', 128);
                $table->string('ip_address', 45)->nullable();
                $table->string('status', 20)->default('open');
                $table->boolean('is_read')->default(false);
                $table->boolean('is_blocked')->default(false);
                $table->boolean('is_viewing')->default(false);
                $table->boolean('is_typing')->default(false);
                $table->timestamp('last_activity')->useCurrent();
                $table->timestamp('last_presence')->nullable();
                $table->timestamp('created_at')->useCurrent();
            });
        } else {
            Schema::table('chat_sessions', function (Blueprint $table) {
                if (!Schema::hasColumn('chat_sessions', 'is_blocked')) {
                    $table->boolean('is_blocked')->default(false)->after('is_read');
                }
                if (!Schema::hasColumn('chat_sessions', 'is_viewing')) {
                    $table->boolean('is_viewing')->default(false)->after('is_blocked');
                }
                if (!Schema::hasColumn('chat_sessions', 'is_typing')) {
                    $table->boolean('is_typing')->default(false)->after('is_viewing');
                }
                if (!Schema::hasColumn('chat_sessions', 'last_presence')) {
                    $table->timestamp('last_presence')->nullable()->after('last_activity');
                }
            });
        }

        if (!Schema::hasTable('chat_messages')) {
            Schema::create('chat_messages', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('session_id', 64)->index();
                $table->string('sender', 20)->default('visitor');
                $table->text('message')->nullable();
                $table->string('message_type', 20)->default('text');
                $table->string('file_path')->nullable();
                $table->string('file_name')->nullable();
                $table->string('status', 20)->default('sent');
                $table->boolean('is_read')->default(false);
                $table->timestamp('created_at')->useCurrent();
            });
        } else {
            Schema::table('chat_messages', function (Blueprint $table) {
                if (!Schema::hasColumn('chat_messages', 'status')) {
                    $table->string('status', 20)->default('sent')->after('is_read');
                }
            });
        }

        if (!Schema::hasTable('admin_users')) {
            Schema::create('admin_users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username', 50)->unique();
                $table->string('password_hash');
                $table->string('display_name', 100)->default('Support Agent');
                $table->timestamp('last_activity')->nullable();
                $table->boolean('is_viewing')->default(false);
                $table->boolean('is_typing')->default(false);
                $table->string('viewing_session_id', 64)->nullable();
                $table->timestamps();
            });
        } else {
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
        // These tables may already contain conversations created by the legacy
        // PHP chat, so rolling this compatibility migration back must not erase
        // the existing inbox.
    }
};
