<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use Mail;
use App\Mail\GamersAndPlayers;
use Illuminate\Support\Facades\Log;
use App\Models\History;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralSetting;
class SendMailGamesandPlayersEveryMonth extends Command
{
    public $limit_amount = 0;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendMailGamesandPlayersEveryMonth:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "in every first month gamers and players previous month's data will send to admin";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $settings = GeneralSetting::first();
        $limit_amount = $settings->limit_amount;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $limit_amount = $this->limit_amount;
            // dd($id);


                $history = History::where('type', 'load')
                                    // ->where('created_at', '>', Carbon::now()
                                    // ->subDays(30))
                                    // ->orderBy('id','desc')
                                    // ->whereDate('created_at', '>=', date(($filter_start)))
                                    ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id',])
                                    ->groupBy('form_id')
                                    ->with('form')
                                    ->whereHas('form')
                                    ->get()->toArray();

                // $history = History::with('form')
                //                     ->whereHas('form')
                //                     ->where('type','load')
                //                     ->whereDate('created_at', '>=', date(($filter_start)))->get();
                // $history = FormBalance::with('account')->with('form')
                // ->whereHas('form')
                // ->with('created_by')
                // ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                // ->orderBy('id', 'desc')
                // ->get()
                // ->toArray();
                // dd($history);
                $final = [];
                $forms = [];

                // $data = [
                //     ['SN', 'Date', 'FB Name','Game','Game ID','Amount','Type','Creator']
                // ];
                if (!empty($history))
                {
                    foreach ($history as $a => $b)
                    {
                        $totals = ['load' => 0];

                        $form = Form::where('id', $b['form_id'])->first();
                        if (!empty($form))
                        {
                            $form->toArray();
                            if (!(isset($final[$b['form_id']])))
                            {
                                $final[$b['form_id']] = [];
                            }
                            $final[$b['form_id']]['spinner_key'] = $form['token'];
                            $final[$b['form_id']]['form_id'] = $b['form_id'];
                            $final[$b['form_id']]['full_name'] = $form['full_name'];
                            $final[$b['form_id']]['number'] = $form['number'];
                            $final[$b['form_id']]['email'] = $form['email'];
                            $final[$b['form_id']]['facebook_name'] = $form['facebook_name'];
                        }
                        // if (isset($final[$b['form_id']]['totals']))
                        // {
                        //     $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        // }
                        // $totals['load'] = $totals['totals'];
                        // $totals['load'] = $totals['load'] + $b['amount_loaded'];
                        $final[$b['form_id']]['totals']['load'] = $b['total'];
                    }
                }

                $forms = json_encode($final);
                // dd($forms);
                // $balance_load = $forms['totals']['load'];

            // dd($data);
            Mail::to('mangaletamang65@gmail.com')->send(new GamersAndPlayers($forms));
            Log::channel('spinnerBulk')->info("Custom mail sent successfully to " .' individual');
            // return redirect()->back()->withInput()->with('success', 'Mail Sent');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($e);
            Log::channel('spinnerBulk')->info($bug);
            // return redirect()->back()->withInput()->with('error', $bug);
        }
    }
}
