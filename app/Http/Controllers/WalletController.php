<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WithdrawTranscationDetail;
use Carbon\Carbon;
use App\Models\WalletDetail;
use DataTables;
use App\Models\PlayersDetail;
use App\Models\WalletTranscationDetails;
use App\Models\BonusWalletDetail;

class WalletController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $withdrawRequest = WithdrawTranscationDetail::orderBy('id','desc')->where('status',1)->with('playerId','walletId')->get();
            //dd($withdrawRequest);
            return Datatables::of($withdrawRequest)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action_buttons = '<a style="background: #28a745;color: #fff !important; margin-right:10px;" href="' . route("walletWithdrawEdit", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-lg" data-toggle="tooltip" data-placement="right" >Accept</a>';
                    $action_buttons .= '<a style="background: #f00;color: #fff !important;" href="' . route("walletWithdrawReject", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-lg" data-toggle="tooltip" data-placement="right" >Reject</a>';
                    return $action_buttons;
                })
                ->addColumn('player_id', function ($row) {
                    return $row->walletId->player_id;
                })
                ->addColumn('player_name', function ($row) {
                    return $row->playerId->first_name;
                })
                ->addColumn('wallet_balance', function ($row) {
                    return $row->walletId->current_amount;
                })

                ->rawColumns(['action','player_id','player_name','wallet_balance'])
                ->make(true);
        }
        return view('wallet.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){

        $todayTime  = Carbon::now();
        $transcation = WithdrawTranscationDetail::where('id', $id)->first();
        $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();

        $walletSaveDetail = WalletDetail::where('player_id',$request->player_id)->update([
            'total_amt_withdraw'    => $walletDetail->total_amt_withdraw + $transcation->amt_withdraw,
            'current_amount'        => $walletDetail->current_amount  - $transcation->amt_withdraw,
            'no_of_withdraw'        => $walletDetail->no_of_withdraw + 1 ,
            'last_withdraw_date'        => $todayTime->format("Y-m-d"),
        ]);
        $details = WithdrawTranscationDetail::where('id', $id)->update([
            'status'                    => 4,
            'notes'                     => $request->notes ? $request->notes :'',
            'transcation_number'        => $request->transcation_number,
            'withdraw_date'    => $todayTime->format("Y-m-d"),
        ]);

            $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id     = $request->player_id;
                $transcationDetail->wallet_id     = $walletDetail->id;
                $transcationDetail->type          = 'debit';
                $transcationDetail->notes        = $request->notes;
                $transcationDetail->use_of        = $transcation->payment_type;
                 $transcationDetail->wallet_type    = 'winning_balance';
                $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetail->amount        = $transcation->amt_withdraw;
            $transcationDetail->save();

        if($details){
            notify()->success("Withdraw is request Accept","Success","topRight");
            return redirect()->route('withdraw.list');
            // return redirect('/wallet/withdraw/list')->with(['Success'=>'Withdraw is request Rejected']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request,$id){


        $details = WithdrawTranscationDetail::where('id', $id)->update([
            'status'          => 2,
        ]);

        if($details){
            notify()->success("Withdraw is request Rejected","Success","topRight");
            return redirect()->route('withdraw.list');
            // return redirect('/wallet/withdraw/list')->with(['Success'=>'Withdraw is request Rejected']);
        }
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id){

        $transcation = WithdrawTranscationDetail::where('id',$id)->with('playerId','walletId')->first();
        $action      = "1";
        return view('wallet.accept',compact('transcation','action'));
    }

    public function showPage(){

        $players = PlayersDetail::with('user')->get();        
        return view('wallet.modifyPlayerWallet',compact('players'));
    }

    public function getPlayerWallet($id){
       
        $walletDetail = WalletDetail::where('player_id',$id)->first();              
        return response()->json($walletDetail);

    }
    public function getPlayerBonusWallet($id){
       
        $BonuswalletDetail = BonusWalletDetail::where('player_id',$id)->first();              
        return response()->json($BonuswalletDetail);

    }

    public function modifyPlayerWallet(Request $request){

        // dd($request->all());
        $todayTime  = Carbon::now();
        if($request->wallet_type == 'bonus_balance'){
            $bonuswalletDetails = BonusWalletDetail::where('player_id',$request->player_id)->first();
            if($request->type == 'debit'){
                $walletSaveDetails = BonusWalletDetail::where('player_id',$request->player_id)->update([
                    'total_amt_added'        => $bonuswalletDetails->total_amt_added + $request->coupon_amount,
                    'current_amount'        => $bonuswalletDetails->current_amount  - $request->coupon_amount,
                    'last_added_date'        => $todayTime->format("Y-m-d"),
                ]);
            } else{
                $walletSaveDetails = BonusWalletDetail::where('player_id',$request->player_id)->update([
                    'total_amt_added'        => $bonuswalletDetails->total_amt_added + $request->coupon_amount,
                    'current_amount'        => $bonuswalletDetails->current_amount  + $request->coupon_amount,
                    'last_added_date'        => $todayTime->format("Y-m-d"),
                ]);
            }

            $transcationDetails = new WalletTranscationDetails;
            $transcationDetails->player_id     = $request->player_id;
            $transcationDetails->wallet_id     = $bonuswalletDetails->id;
            $transcationDetails->type          = $request->type;
            $transcationDetails->use_of        =  'Admin panel';
            $transcationDetails->notes        = $request->notes;
            $transcationDetails->trans_date    = $todayTime->format("Y-m-d");
            $transcationDetails->amount        = $request->coupon_amount;
            $transcationDetails->wallet_type    = $request->wallet_type;
            $transcationDetails->save();

        }else{

            $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();      
            if($request->type == 'debit'){
                $walletSaveDetail = WalletDetail::where('player_id',$request->player_id)->update([
                    'total_amt_load'        => $walletDetail->total_amt_load + $request->coupon_amount,
                    'current_amount'        => $walletDetail->current_amount  - $request->coupon_amount,
                    'no_of_load'            => $walletDetail->no_of_load - 1 ,
                    'last_load_date'        => $todayTime->format("Y-m-d"),
                ]);
            } else{
                $walletSaveDetail = WalletDetail::where('player_id',$request->player_id)->update([
                    'total_amt_load'        => $walletDetail->total_amt_load + $request->coupon_amount,
                    'current_amount'        => $walletDetail->current_amount  + $request->coupon_amount,
                    'no_of_load'            => $walletDetail->no_of_load + 1 ,
                    'last_load_date'        => $todayTime->format("Y-m-d"),
                ]);            
            }

            $transcationDetail = new WalletTranscationDetails;
            $transcationDetail->player_id     = $request->player_id;
            $transcationDetail->wallet_id     = $walletDetail->id;
            $transcationDetail->type          = $request->type;
            $transcationDetail->use_of        = 'Admin panel';
            $transcationDetail->notes        = $request->notes;
            $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
            $transcationDetail->amount        = $request->coupon_amount;
            $transcationDetail->wallet_type    = $request->wallet_type;
            $transcationDetail->save();
        }
       
            notify()->success("Withdraw is request Rejected","Success","topRight");
            return redirect()->route('withdraw.list');
            
    }

}
