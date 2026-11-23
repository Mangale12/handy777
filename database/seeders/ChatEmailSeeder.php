<?php

namespace Database\Seeders;

use App\Models\ChatEmail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChatEmailSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasTable('forms') || !Schema::hasTable('chat_emails')) {
            return;
        }

        DB::table('forms')
            ->select(['email', 'full_name'])
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->orderBy('id')
            ->get()
            ->each(function ($form) {
                $email = Str::lower(trim((string) $form->email));

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)
                    || ChatEmail::query()->whereRaw('LOWER(email) = ?', [$email])->exists()) {
                    return;
                }

                do {
                    $chatCode = Str::upper(Str::random(12));
                } while (ChatEmail::query()->where('chat_code', $chatCode)->exists());

                ChatEmail::create([
                    'email' => $email,
                    'chat_code' => $chatCode,
                    'display_name' => trim((string) $form->full_name) ?: null,
                    'allow_chat' => true,
                ]);
            });
    }
}
