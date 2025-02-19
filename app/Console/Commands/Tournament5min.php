<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Api\TournamentController;
use App\Models\Tournament;
use Carbon\Carbon;
use App\Models\TournamentRegistartion;
class Tournament5min extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron5min:cron';

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
        $todayTime = Carbon::now();
        $start = $todayTime->format("Y-m-d H:i:s");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(5);
        $tournament = Tournament::where('tournament_interval', 5)->update([
            'end_time'    => $end_time,
            'start_time'    => $end,
        ]);
        $tournament = Tournament::where('tournament_interval', 5)->get();
        foreach($tournament as $tour)
        {
            $register= TournamentRegistartion::where('tournament_id',$tour->id)->delete();
        }
        //$response = ['status'=>'Success','message'=>'Tournament Completed ','data' => $tournament];
       // return response($response, 200);
        \Log::info("15 min Cron is working fine!");
        return 0;
    }
}
