<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PageSuspendedMail;

class SendHackedAlert extends Command
{
    /**
     * Run this using:
     *   php artisan mail:send-alert --test   (sends 1 test mail to your emails, marks nobody)
     *   php artisan mail:send-alert          (sends to real players)
     */
    protected $signature = 'mail:send-alert {--test : Send only to test emails}';

    protected $description = 'Send page suspended notification to all player emails';

    public function handle()
    {
        $testMode = $this->option('test');

        // 1. Get only users with valid emails
        $players = DB::table('forms')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->select('full_name', 'email', 'jan_mail', 'id')
            ->latest()
            ->where('jan_mail', 0)
            ->take($testMode ? 1 : 400) // 400 per run to stay under Gmail's daily limit
            // ->where('id', 1696)
            ->get();

        foreach ($players as $player) {
            try {

                // ✅ Test mode: send to test emails only, then stop
                if ($testMode) {
                    Mail::to(['mangaletamang65@gmail.com', 'americangamingclub@gmail.com'])
                        ->send(new PageSuspendedMail($player->full_name));

                    $this->info('Test mail sent. Check your inbox.');
                    return Command::SUCCESS;
                }

                // ✅ Send to actual user
                Mail::to($player->email)
                    ->send(new PageSuspendedMail($player->full_name));

                // ✅ Store tracking data
                DB::table('forms')
                    ->where('id', $player->id)
                    ->update(['jan_mail' => 1]);

                Log::channel('cronLog')->info("Suspension notice sent to: " . $player->email);
                $this->info("Sent: {$player->email}");

            } catch (\Exception $e) {

                Log::channel('cronLog')->error("Failed: {$player->email} " . $e->getMessage());
                $this->error("Failed: {$player->email}");
            }

            usleep(500000); // 0.5s pause between sends
        }

        return Command::SUCCESS;
    }
}