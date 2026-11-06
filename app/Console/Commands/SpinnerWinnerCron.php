<?php

namespace App\Console\Commands;

use App\Models\Form;
use App\Models\GeneralSetting;
use App\Models\History;
use App\Models\SpinnerWinner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SpinnerWinnerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SpinnerWinnerCron:cron';

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
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $spinner_winner = SpinnerWinner::create([
           'full_name'=>"mangal tamang",
           'form_id'=>712,
           ]);
    }
}
