<?php

namespace App\Http\Controllers;

use App\Models\SupportDetail;
use App\Models\Tournament;
use App\Models\WalletDetail;
use App\Models\WithdrawTranscationDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Artisan;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $players= User::where('user_type',2)->with('player_details')->latest()->get();
      //  dd($players);
        $latest_players= User::where('user_type',2)->where( 'created_at', '>', Carbon::now()->subDays(2))->with('player_details')->latest()->get();
       // dd($latest_players);
        $gross_income= WalletDetail::sum('total_amt_load');
        $net_income= WalletDetail::sum('total_amt_withdraw');
        $tournments= Tournament::get();
        $withdraw_request = WithdrawTranscationDetail::count();
        $support= SupportDetail::count();


       return view('index',compact('players','latest_players','gross_income','net_income','tournments','withdraw_request','support'));
    }

    public function settings(){
        $user_id=  Auth::user()->id;
        $app_name = env('APP_NAME');


       // dd($app_name);
        $user = User::where('id',$user_id)->first();
        return view('settings.edit',compact('user'));
    }
    //settings module update user profile details
    public function settingsUpdate(Request $request,$id){

        $user = User::where('id',$id)->update([
            'first_name' => $request->first_name,
            'email'      => $request->email,
            'mobile_no'  => $request->mobile_no
        ]);
        if($user){
            notify()->success("Updated Successfully!","Success","topRight");
            return redirect()->route('admin.dashboard');
        }
    }
    //settings module update user password
    public function updatePassword(Request $request,$id){

        $user = User::where('id',$id)->update([
               'password' => Hash::make($request->password),
        ]);

        if($user){
            notify()->success("Updated Successfully!","Success","topRight");
            return redirect()->route('admin.dashboard');
        }
    }
    public function updateLogo(Request $request){
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if(!is_dir(public_path('/img/')))
            {
                mkdir(public_path('/img/'),775,true);
            }
            $thumbnailImage = Image::make($image->getRealPath());
            $thumbnailPath = public_path().'/img/';
           // $originalPath = public_path().'img/';
            $imgName = 'logo'.'.'.'jpg';
            //$thumbnailImage->save($originalPath.$image_name);
            $thumbnailImage->resize(150,150);
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 777, true);
            }
            if (file_exists($thumbnailPath)){
                    unlink($thumbnailPath.$imgName);
             }
            $thumbnailImage->save($thumbnailPath.$imgName);

           }
        return redirect()->route('admin.dashboard')->with('success','Logo Updated successfully!');
    }
    public function updateAppName(Request $request)
    {   $appName = str_replace(' ', '', $request->app_name);

        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
            'APP_NAME='.config('app.name'), 'APP_NAME='.$appName, file_get_contents($path)
                ));
        }
        $exitCode = Artisan::call('config:cache');
        $dad = Artisan::call('cache:clear');
        return redirect()->route('admin.dashboard')->with('success','App Name Updated successfully!');
    }

}
