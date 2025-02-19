<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlayersDetail;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Models\WalletDetail;
use App\Models\BonusWalletDetail;
use File;
use App\Models\BonusWalletTranscationDetail;
use App\Models\BoatControl;
use App\Models\VersionControl;
class PlayerController extends Controller
{
    public function playersList()
    {
        $players = PlayersDetail::get();

        $response = ['status'=>'Success','message'=>'Players Listed Successfully','data' => $players];
        return response($response, 200);
    }

    public function playersCreate(Request $request)
    {
        $players = PlayersDetail::create([
        'user_id' => $request->user_id,
        'first_name'=> $request->first_name,
        'last_name'=> $request->last_name,
        'refer_code' => $request->refer_code,
        'join_code'=> $request->join_code,
        'no_of_participate'=> $request->no_of_participate,
        'no_of_loose' => $request->no_of_loose,
        'no_of_total_win' => $request->no_of_total_win,
        'no_of_2win'=> $request->no_of_2win,
        'no_of_4win'=> $request->no_of_4win,
        'device_type'=> $request->device_type,
        'device_token'=> $request->device_token,
        'banned' => $request->banned
        ]);

        $response = ['status'=>'Success','message'=>'Players created Successfully', 'data'=> $players];
        return response($response, 200);
    }
       
   
    
    
    
    public function playersUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

         if($request->join_code != null && $request->join_code != ''){
            $user = PlayersDetail::where('refer_code', $request->join_code)->first();
           if ($user) {
               
               $players = PlayersDetail::where('user_id',$request->player_id)->update([
                'join_code'    => $request->join_code,
            ]);
               
          $response = ['status'=>'success'];  
        return response($response, 200); 
           }
           else{
               
               $response = ['status'=>'fail'];
        return response($response, 200); 
           }
         
           
        }
    



        if($request->mobile_no != null && $request->mobile_no != '' && $request->mobile_no_validation =='yes'){
            $user = User::where('mobile_no', $request->mobile_no)->first();
           if ($user) {
                 $response = ['status'=>'fail','message'=>'mobile number already exist'];
        return response($response, 200); 
           }
           else{
               
                $response = ['status'=>'success','message'=>'mobile number not exist'];
        return response($response, 200); 
           }
         
           
        }
        
           else{
               
               
            $users = User::where('id', $request->player_id)->update([
                'mobile_no'    => $request->mobile_no,
            ]);
            
          
           
        }
        
                 if($request->join_code != null && $request->join_code != ''){
            $user = PlayersDetail::where('refer_code', $request->join_code)->first();
           if ($user) {
               
               $players = PlayersDetail::where('user_id',$request->player_id)->update([
                'join_code'    => $request->join_code,
            ]);
               
          $response = ['status'=>'success'];  
        return response($response, 200); 
           }
           else{
               
               $response = ['status'=>'fail'];
        return response($response, 200); 
           }
         
           
        }
    

        if($request->first_name != null && $request->first_name != ''){
            $users = User::where('id', $request->player_id)->update([
                'first_name'    => $request->first_name,
            ]);
            $players = PlayersDetail::where('user_id',$request->player_id)->update([
                'first_name'    => $request->first_name,
            ]);
        }

        if($request->last_name != null && $request->last_name != ''){
            // $users = User::where('id', $request->player_id)->update([
            //     'last_name'    => $request->last_name,
            // ]);
            $players = PlayersDetail::where('user_id',$request->player_id)->update([
                'first_name'    => $request->last_name,
            ]);
        }

        if(($request->four_win != null && $request->four_win != '') || ($request->two_win != null && $request->two_win != '')){
            $players = PlayersDetail::where('user_id',$request->player_id)->first();
            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'no_of_participate'     => $players->no_of_participate+1,
                'no_of_total_win'       => $players->no_of_total_win+1,
                'no_of_2win'            => ($request->two_win ? (($players->no_of_2win == '') ? 1 : $players->no_of_2win+1):$players->no_of_2win ) ,
                'no_of_4win'            => ($request->four_win ? (($players->no_of_4win == '') ? 1 : $players->no_of_4win+1):$players->no_of_4win ),
            ]);
        }
        if($request->lose != null && $request->lose != ''){
            $players = PlayersDetail::where('user_id',$request->player_id)->first();

            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'no_of_participate'     => $players->no_of_participate+1,
                'no_of_loose'     => $players->no_of_loose + 1,
            ]);
        }

        $response = ['status'=>'Success','message'=>'Players Details Updated Successfully'];
        return response($response, 200);
    }

    public function playersImageUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        if($request->profile_url_image) {
            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'profile_url_image'     => $request->profile_url_image,
            ]);
            $response = ["message" =>'Player Profile Url Image Update Successfully'];
            return response($response, 200);
        }
        if($request->hasFile('profile_image')) {
            $destinationPath    = public_path('/player/images');

            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $image              = $request->file('profile_image');
            $imagename          = date('d-m-Y-H-i').$image->getClientOriginalName();
            $imagePath          = $destinationPath . "/" . $imagename;
            $image->move($destinationPath, $imagename);
            $playersDetail = PlayersDetail::where('user_id', $request->player_id)->update([
                'profile_image'     => $imagename,
                'profile_url_image'     => '',
            ]);
            $response = ["message" =>'Player Profile Image Update Successfully'];
            return response($response, 200);
        }


    }

    public function playersImageGet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $players = PlayersDetail::where('user_id',$request->player_id)->first();
        if($players->profile_url_image != '' && $players->profile_url_image != null){

            $data['image'] = $players->profile_url_image;
        } else{
            $profile_image 	= ($players->profile_image != '') ?asset( 'player/images/' . $players->profile_image):"";
            $data['image'] = $profile_image;
        }
        $response = ["message" =>'Player Profile Image Update Successfully','data'=>$data];
        return response($response, 200);
    }

    public function playerDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $app=VersionControl::first();
        $bot=BoatControl::first();
        $players = PlayersDetail::where('user_id',$request->player_id)->first();
        $coupon= BonusWalletTranscationDetail::where('player_id',$request->player_id)->first();
        $users = User::where('id', $request->player_id)->first();
        $mobilnumber=$users->mobile_no;
        $wallet = WalletDetail::where('player_id',$request->player_id)->first();
        $bonus_wallet = BonusWalletDetail::where('player_id',$request->player_id)->first();
        $response = ["message" =>'Player Details Fetched Successfully','players' => $players,'mobile'=>$mobilnumber,'wallet'=>$wallet, 'bonus_wallet'=>$bonus_wallet,'coupon'=>$coupon,'App'=>$app,'bot'=>$bot];
        return response($response, 200);
    }


    public function referal_data(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'refer_code' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $players = PlayersDetail::where('refer_code',$request->refer_code)->first();
        if($players != null)
        {
            $response = ["status" =>'success','players' => $players];
        }else{
            $response = ["status" =>'fail',"message" =>'Referal number does not exist'];
        }

        return response($response, 200);
    }
}
