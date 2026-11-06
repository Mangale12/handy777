<?php

namespace App\Console\Commands;
use App\Http\Controllers\NewHomeController;

use Illuminate\Console\Command;
use App\Models\GeneralSetting;

class GamersGamesMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GamersGames:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
         $settings = GeneralSetting::first()->toArray();
        // $this->limit_amount = $settings['limit_amount'];
        $this->limit_amount = $settings['limit_amount'];
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pdf = new NewHomeController();
     $pdf->createPDF();
     return true;
    }
}
