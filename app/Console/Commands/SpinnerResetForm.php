<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use Exception;
use Illuminate\Support\Facades\Log;

class SpinnerResetForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SpinnerResetForm:cron';

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
        try {
            // Form::where('deleted_at',null)->update([
            //     'balance' => 0
            // ]);
            Log::channel('cronLog')->info('Spinner Reset Successfull');
        } catch (Exception $ex) {
            Log::channel('cronLog')->info('Spinner Reset Error : Reason Below');
            Log::channel('cronLog')->info($ex->getMessage());
        }
    }
}
