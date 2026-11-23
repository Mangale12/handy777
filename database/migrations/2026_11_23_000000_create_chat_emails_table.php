<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('chat_emails')) {
            Schema::create('chat_emails', function (Blueprint $table) {
                $table->id();
                $table->string('email', 150)->unique();
                $table->string('chat_code', 64)->unique();
                $table->string('display_name', 100)->nullable();
                $table->boolean('allow_chat')->default(true)->index();
                $table->text('notes')->nullable();
                $table->timestamp('last_chat_at')->nullable();
                $table->timestamps();
            });
        }

        // Existing players should keep their current access when this allow-list
        // is introduced. The standalone seeder also keeps this in sync for new
        // form records when the database is seeded again.
        if (Schema::hasTable('forms')) {
            DB::table('forms')
                ->select(['email', 'full_name'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->orderBy('id')
                ->get()
                ->each(function ($form) {
                    $email = Str::lower(trim((string) $form->email));

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)
                        || DB::table('chat_emails')->where('email', $email)->exists()) {
                        return;
                    }

                    do {
                        $chatCode = Str::upper(Str::random(12));
                    } while (DB::table('chat_emails')->where('chat_code', $chatCode)->exists());

                    DB::table('chat_emails')->insert([
                        'email' => $email,
                        'chat_code' => $chatCode,
                        'display_name' => trim((string) $form->full_name) ?: null,
                        'allow_chat' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });
        }
    }

    public function down()
    {
        Schema::dropIfExists('chat_emails');
    }
};
