<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BonusWalletDetail;
use App\Models\BonusWalletTranscationDetail;
use App\Models\Tournament;
use App\Models\TournamentRegistartion;
use Illuminate\Http\Request;
use App\Models\WithdrawTranscationDetail;
use Carbon\Carbon;
use App\Models\WalletDetail;
use App\Models\WalletTranscationDetails;
use Illuminate\Support\Facades\Validator;
use App\Models\PlayersDetail;
class WalletController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function walletAmountLoad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            
           
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $todayTime  = Carbon::now();
        if($request->after_match==null && $request->after_match==''){
        $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();
        if($walletDetail != null){
            $walletSaveDetail = WalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_load'        => $walletDetail->total_amt_load + $request->loaded_amount,
                'current_amount'        => $walletDetail->current_amount  + $request->loaded_amount,
                'no_of_load'            => $walletDetail->no_of_load + 1 ,
                'last_load_date'        => $todayTime->format("Y-m-d"),
            ]);


            $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id     = $request->player_id;
                $transcationDetail->wallet_id     = $walletDetail->id;
                $transcationDetail->type          = 'credit';
                $transcationDetail->use_of        = $request->use_of;
                $transcationDetail->notes        = $request->notes;
                $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetail->amount        = $request->loaded_amount;
                $transcationDetail->wallet_type    = $request->wallet_type;
            $transcationDetail->save();
            if($request->coupon_name!=null && $request->coupon_name!='' ){
                
                  if($request->coupon_name=='coupon_bonus'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'coupon_bonus'    => '1',
            ]);
       }
               else  if($request->coupon_name=='upi_money'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'upi_money'    => '1',
            ]);
       }
       else  if($request->coupon_name=='offer'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'offer'    => '1',
            ]);
       }
       else  if($request->coupon_name=='cool_twenty'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'cool_twenty'    => '1',
            ]);
       }
       else  if($request->coupon_name=='win_twenty'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'win_twenty'    => '1',
            ]);
       }
       else  if($request->coupon_name=='upi_offer'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'upi_offer_lastused'=> $todayTime->format("Y-m-d"),
            ]);
       }
       else  if($request->coupon_name=='xtra_ten'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'xtra_ten_lastused'=> $todayTime->format("Y-m-d"),
            ]);
       }
       else  if($request->coupon_name=='play_ten'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'play_ten_lastused'=> $todayTime->format("Y-m-d"),
            ]);
       }
           
            
            
            if($request->coupon_wallet_type=='play_balance'){
                 $walletDetails = WalletDetail::where('player_id',$request->player_id)->first();
               $walletSaveDetails = WalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_load'        => $walletDetails->total_amt_load + $request->coupon_amount,
                'current_amount'        => $walletDetails->current_amount  + $request->coupon_amount,
                'no_of_load'            => $walletDetails->no_of_load + 1 ,
                'last_load_date'        => $todayTime->format("Y-m-d"),
            ]); 
                       
       $transcationDetails = new WalletTranscationDetails;
                $transcationDetails->player_id     = $request->player_id;
                $transcationDetails->wallet_id     = $walletDetails->id;
                $transcationDetails->type          = 'credit';
                $transcationDetails->use_of        = $request->coupon_use_of;
                $transcationDetails->notes        = $request->coupon_notes;
                $transcationDetails->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetails->amount        = $request->coupon_amount;
                $transcationDetails->wallet_type    = $request->coupon_wallet_type;
            $transcationDetails->save();
            }
            else{
                $bonuswalletDetails = BonusWalletDetail::where('player_id',$request->player_id)->first();
                $walletSaveDetails = BonusWalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_added'        => $bonuswalletDetails->total_amt_added + $request->coupon_amount,
                'current_amount'        => $bonuswalletDetails->current_amount  + $request->coupon_amount,
                'last_added_date'        => $todayTime->format("Y-m-d"),
            ]);
                   
       $transcationDetails = new WalletTranscationDetails;
                $transcationDetails->player_id     = $request->player_id;
                $transcationDetails->wallet_id     = $bonuswalletDetails->id;
                $transcationDetails->type          = 'credit';
                $transcationDetails->use_of        = $request->coupon_use_of;
                $transcationDetails->notes        = $request->coupon_notes;
                $transcationDetails->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetails->amount        = $request->coupon_amount;
                $transcationDetails->wallet_type    = $request->coupon_wallet_type;
            $transcationDetails->save();
            }
            
            
            
            
     
            
            
            
            }

     
           
            $response = ['status'=>'Success','message'=>'Amount Successfully Added to Wallet'];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }
            
        }
        else{
            if($request->game_status=='win'){
                    if($request->loaded_amount=='0'){
            $players = PlayersDetail::where('user_id',$request->player_id)->first();

            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'no_of_participate'     => $players->no_of_participate+1,
                'no_of_loose'     => $players->no_of_loose + 1,
            ]);
            
            $response = ['status'=>'Success','lose'=>'loss updated'];
                  return response($response, 200);
        }
                
                  $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();
        if($walletDetail != null){
            $walletSaveDetail = WalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_load'        => $walletDetail->total_amt_load + $request->loaded_amount,
                'current_amount'        => $walletDetail->current_amount  + $request->loaded_amount,
                'no_of_load'            => $walletDetail->no_of_load + 1 ,
                'last_load_date'        => $todayTime->format("Y-m-d"),
            ]);


            $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id     = $request->player_id;
                $transcationDetail->wallet_id     = $walletDetail->id;
                $transcationDetail->type          = 'credit';
                $transcationDetail->use_of        = $request->use_of;
                $transcationDetail->notes        = $request->notes;
                $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetail->amount        = $request->loaded_amount;
                $transcationDetail->wallet_type    = $request->wallet_type;
            $transcationDetail->save();
                  if(($request->four_win != null && $request->four_win != '') || ($request->two_win != null && $request->two_win != '')){
            $players = PlayersDetail::where('user_id',$request->player_id)->first();
            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'no_of_participate'     => $players->no_of_participate+1,
                'no_of_total_win'       => $players->no_of_total_win+1,
                'no_of_2win'            => ($request->two_win ? (($players->no_of_2win == '') ? 1 : $players->no_of_2win+1):$players->no_of_2win ) ,
                'no_of_4win'            => ($request->four_win ? (($players->no_of_4win == '') ? 1 : $players->no_of_4win+1):$players->no_of_4win ),
            ]);
        }
               
            $response = ['status'=>'Success','message'=>'Amount Added to winning balance'];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }
                
                 }
            else{
                
                        if($request->lose != null && $request->lose != ''){
            $players = PlayersDetail::where('user_id',$request->player_id)->first();

            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'no_of_participate'     => $players->no_of_participate+1,
                'no_of_loose'     => $players->no_of_loose + 1,
            ]);
            
            $response = ['status'=>'Success','lose'=>'loss updated'];
                  return response($response, 200);
        }
         
            }
            
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function walletAmountWithdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            'withdraw_amount' => 'required',
            
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $todayTime  = Carbon::now();

        $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();
        if($walletDetail != null){
            $walletSaveDetail = WalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_withdraw'    => $walletDetail->total_amt_withdraw + $request->withdraw_amount,
                'current_amount'        => $walletDetail->current_amount  - $request->withdraw_amount,
                'no_of_withdraw'        => $walletDetail->no_of_withdraw + 1 ,
                'last_withdraw_date'        => $todayTime->format("Y-m-d"),
            ]);


            $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id     = $request->player_id;
                $transcationDetail->wallet_id     = $walletDetail->id;
                $transcationDetail->type          = 'debit';
                $transcationDetail->use_of        = $request->use_of;
                $transcationDetail->notes        = $request->notes;
                $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetail->amount        = $request->withdraw_amount;
                $transcationDetail->wallet_type    = 'winning_balance';
            $transcationDetail->save();

            $data= $transcationDetail;

            $response = ['status'=>'Success','message'=>'Amount Successfully Withdraw from Wallet','data' => $data];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function walletGameLoad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required'
            
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $todayTime  = Carbon::now();

       if($request->coupon_name=='coupon_bonus'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'coupon_bonus'    => '1',
            ]);
       }
               else  if($request->coupon_name=='upi_money'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'upi_money'    => '1',
            ]);
       }
       else  if($request->coupon_name=='offer'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'offer'    => '1',
            ]);
       }
       else  if($request->coupon_name=='cool_twenty'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'cool_twenty'    => '1',
            ]);
       }
       else  if($request->coupon_name=='win_twenty'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'win_twenty'    => '1',
            ]);
       }
       else  if($request->coupon_name=='upi_offer'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'upi_offer_lastused'=> $todayTime->format("Y-m-d"),
            ]);
       }
       else  if($request->coupon_name=='xtra_ten'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'xtra_ten_lastused'=> $todayTime->format("Y-m-d"),
            ]);
       }
       else  if($request->coupon_name=='play_ten'){
               
            $coupon = BonusWalletTranscationDetail::where('player_id', $request->player_id)->update([
                'play_ten_lastused'=> $todayTime->format("Y-m-d"),
            ]);
       }
       
       $coupons= BonusWalletTranscationDetail::where('player_id',$request->player_id)->first();
          $response = ['status'=>'Success','data' =>$coupons,'today'=>$todayTime->format("Y-m-d")];
            return response($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function walletHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $walletWithdraw = WalletTranscationDetails::where('player_id',$request->player_id)->get();
        if($walletWithdraw != null){
            $response = ['status'=>'Success','message'=>'Request Listed Successfully','data' =>$walletWithdraw];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function walletWithdrawRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $walletWithdraw = WithdrawTranscationDetail::where('player_id',$request->player_id)->get();
        if($walletWithdraw != null){
            $response = ['status'=>'Success','message'=>'Request Listed Successfully','data' =>$walletWithdraw];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawRequestAdd(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            'amt_withdraw' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $todayTime  = Carbon::now();

        $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();

        if($walletDetail != null){
            $transcationDetail = new WithdrawTranscationDetail;
                $transcationDetail->player_id                = $request->player_id;
                $transcationDetail->wallet_id                = $walletDetail->id;
                $transcationDetail->withdraw_request_date    = $todayTime->format("Y-m-d");
                $transcationDetail->amt_withdraw             = $request->amt_withdraw;
                $transcationDetail->payment_type             = $request->payment_type;
                $transcationDetail->account_number           = $request->account_number ? $request->account_number  :'';
                $transcationDetail->ifsc_code                = $request->ifsc_code ? $request->ifsc_code  :'';
                $transcationDetail->mobile_number            = $request->mobile_number ? $request->mobile_number :'';
                $transcationDetail->status                   = 1;
                // $transcationDetail->wallet_type    = 'winning_amount';
            $transcationDetail->save();


            $response = ['status'=>'Success','message'=>'Request Sent'];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }

    }


    public function bonuswalletAmountLoad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            'loaded_amount' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $todayTime  = Carbon::now();

        $walletDetail = BonusWalletDetail::where('player_id',$request->player_id)->first();
     
        if($walletDetail != null){
            $walletSaveDetail = BonusWalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_added'        => $walletDetail->total_amt_added + $request->loaded_amount,
                'current_amount'        => $walletDetail->current_amount  + $request->loaded_amount,
                'last_added_date'        => $todayTime->format("Y-m-d"),
            ]);


              $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id     = $request->player_id;
                $transcationDetail->wallet_id     = $walletDetail->id;
                $transcationDetail->type          = 'credit';
                $transcationDetail->use_of        = $request->use_of;
                $transcationDetail->notes        = $request->notes;
                $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetail->amount        = $request->loaded_amount;
                $transcationDetail->wallet_type    = 'bonus_balance';
            $transcationDetail->save();


                $data= $transcationDetail;
            $response = ['status'=>'Success','message'=>'Amount Successfully Added to Bonus Wallet','data'=> $data];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Bonus Wallet Found'], 422);
        }
    }


    public function bonuswalletAmountWithdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            'withdraw_amount' => 'required',
            
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $todayTime  = Carbon::now();

        $walletDetail = BonusWalletDetail::where('player_id',$request->player_id)->first();
        

        if($walletDetail != null){
            $walletSaveDetail = BonusWalletDetail::where('player_id',$request->player_id)->update([
                'total_amt_used'    => $walletDetail->total_amt_used + $request->withdraw_amount,
                'current_amount'        => $walletDetail->current_amount  - $request->withdraw_amount,
                'last_used_date'        => $todayTime->format("Y-m-d"),
            ]);


            $transcationDetail = new WalletTranscationDetails;
              $transcationDetail->player_id     = $request->player_id;
                $transcationDetail->wallet_id     = $walletDetail->id;
                $transcationDetail->type          = 'debit';
                $transcationDetail->amount          =$request->withdraw_amount;
                $transcationDetail->trans_date    = $todayTime->format("Y-m-d");
                $transcationDetail->use_of    = $request-> use_of;
                $transcationDetail->notes    = $request->notes;
                 $transcationDetail->wallet_type    = 'bonus_balance';
            $transcationDetail->save();

            $data= $transcationDetail;

            $response = ['status'=>'Success','message'=>'Amount Successfully Withdraw from Wallet','data' => $data];
            return response($response, 200);
        } else{
            return response(['status'=>'error','message'=>'No Wallet Found'], 422);
        }
    }


}
