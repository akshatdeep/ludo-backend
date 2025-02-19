<?php

namespace App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\PlayersDetail;
use App\Models\WalletDetail;
use App\Models\BonusWalletDetail;
use App\Models\WalletTranscationDetails;
use App\Models\BonusWalletTranscationDetail;
class ApiAuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'user_type' => 'required',
            'mobile_no' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make('admin123');
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            // 'password' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check('admin123', $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ["status"=>"Login","message" =>'User Successfully Logged in', 'token' => $token,'player_id'=>$user->id,'mobilenumber'=>$user->mobile_no];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users',
            ]);
            if ($validator->fails())
            {
                return response(['errors'=>$validator->errors()->all()], 422);
            }
            $request['password']=Hash::make('admin123');
            $request['remember_token'] = Str::random(10);
            $request['user_type'] = 2;
            $request['mobile_no'] = $request->mobile_no ? $request->mobile_no:'' ;
            $user = User::create($request->toArray());

            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            $playerDetails  = new PlayersDetail;
                $playerDetails->user_id             = $user->id;
                $playerDetails->first_name          = $request->first_name ? $request->first_name : '';
                $playerDetails->last_name           = $request->last_name ? $request->last_name : '';
                $playerDetails->refer_code          = Str::random(8);
                $playerDetails->join_code           = "";
                $playerDetails->no_of_participate   = 0;
                $playerDetails->no_of_loose         = 0;
                $playerDetails->no_of_total_win     = 0;
                $playerDetails->no_of_2win          = 0;
                $playerDetails->no_of_4win          = 0;
                $playerDetails->device_type         = $request->device_type ? $request->device_type : '';
                $playerDetails->device_token        = $request->device_token ? $request->device_token : '';
                $playerDetails->banned              = 0;
            $playerDetails->save();

            $walletDetails    = new WalletDetail;
                $walletDetails->player_id           = $user->id;
                $walletDetails->wallet_ref_number   = Str::random(16);
                $walletDetails->total_amt_load      = 10;
                $walletDetails->total_amt_withdraw  = 0;
                $walletDetails->current_amount      = 10;
                $walletDetails->no_of_load          = 1;
                $walletDetails->no_of_withdraw      = 0;
            $walletDetails->save();

            $bonusWalletDetails    = new BonusWalletDetail;
                $bonusWalletDetails->player_id              = $user->id;
                $bonusWalletDetails->bonus_wallet_ref_number= Str::random(16);
                $bonusWalletDetails->total_amt_added        = 0;
                $bonusWalletDetails->total_amt_used         = 0;
                $bonusWalletDetails->current_amount         = 0;
            $bonusWalletDetails->save();
               $coupon   = new BonusWalletTranscationDetail;
                $coupon->player_id              = $user->id;
          $coupon->save();
          
             $todayTime  = Carbon::now();
              $bonustranscationDetail = new WalletTranscationDetails;
              $bonustranscationDetail->player_id     =  $user->id;
                $bonustranscationDetail->wallet_id     = $bonusWalletDetails->id;
                $bonustranscationDetail->type          = 'credit';
                $bonustranscationDetail->amount          =10;
                $bonustranscationDetail->trans_date    = $todayTime->format("Y-m-d");
                $bonustranscationDetail->use_of    = 'Register';
                $bonustranscationDetail->notes    ='Registration Bonus';
                $bonustranscationDetail->wallet_type    = 'play_balance';
            $bonustranscationDetail->save();
            
            
            
            
            

            $device_token=$request->device_token;
            $key="home";
            // $this->sendAndroidPushNotification( "message sent successfully", $device_token,$key);

            $response = ["status"=>"Register","message" =>'User Registered and Successfully Logged in','token' => $token,'player_id'=>$user->id];
            return response($response, 200);
           
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
