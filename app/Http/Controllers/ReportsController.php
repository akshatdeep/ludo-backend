<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Tournament;
// use App\Http\Requests\TournamentRequest;
// use App\Http\Requests\TournamentUpdateRequest;
use App\Models\PlayersDetail;
use App\User;
use Carbon\Carbon;
use DataTables;
use App\Models\WithdrawTranscationDetail;
use App\Models\WalletTranscationDetails;
use App\Models\WalletDetail;
use App\Models\SupportDetail;

class ReportsController extends Controller
{   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function playerReport(Request $request)
    {  
      
            $playerDetails = PlayersDetail::with('user','wallet_id','bonus_wallet_id')->get();
            $count ='1';       
        return view('report.playerDetails',compact('playerDetails','count'));
    }
    public function withdrawHistory(Request $request,$id)
    {  
        if ($request->ajax()) {
            $withdrawDetails = WalletTranscationDetails::where('player_id',$id)->with('playerId')->get();
            return Datatables::of($withdrawDetails)
                ->addIndexColumn()
                ->addColumn('player_name', function ($row) {
                    $player_name = $row->playerId->first_name.' '.$row->playerId->last_name;
                    return $player_name;
                })
                ->rawColumns(['player_name'])
                ->make(true);
        }  
        $wallet = WalletDetail::where('player_id',$id)->first();    
        return view('report.withdrawHistory',compact('wallet'));
    }   

    public function supportReport()
    {
        $supportRequest = SupportDetail::orderBy('id','desc')->with('playerId')->get();   
       // dd($supportRequest);   
        $count ='1';
        return view('report.supports',compact('supportRequest','count'));
    }
    public function bannedPlayerReport()
    {
        $playerDetails = PlayersDetail::where('banned','1')->with('user','wallet_id','bonus_wallet_id')->get();
        $count ='1';       
        return view('report.bannedPlayers',compact('playerDetails','count'));     
        
    }
     public function transactionActivity()
    {
        $supportRequest = WalletTranscationDetails::orderBy('id','desc')->with('playerId')->get();   
       // dd($supportRequest);   
        $count ='1';
        return view('report.activity',compact('supportRequest','count')); 
        
    }
     public function rechargeActivity()
    {
        $supportRequest = WalletTranscationDetails::where('use_of','top-up')->orderBy('id','desc')->with('playerId')->get();   
       // dd($supportRequest);   
        $count ='1';
        return view('report.recharge',compact('supportRequest','count')); 
        
    }
      public function approvedwithdraw()
    {
        $supportRequest = WithdrawTranscationDetail::where('status','4')->orderBy('id','desc')->with('playerId')->get();   
       // dd($supportRequest);   
        $count ='1';
        return view('report.approvedwithdraw',compact('supportRequest','count')); 
        
    }
      public function rejectedwithdraw()
    {
        $supportRequest = WithdrawTranscationDetail::where('status','2')->orderBy('id','desc')->with('playerId')->get();   
       // dd($supportRequest);   
        $count ='1';
        return view('report.rejectedwithdraw',compact('supportRequest','count')); 
        
    }

}
