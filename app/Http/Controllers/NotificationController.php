<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayersDetail;
use App\User;
use Storage;
class NotificationController extends Controller
{
    public function index()
    {
       return view('notification.index');
    }
   
    public function sendNotification(Request $request)
    {
        // dd($request->all());
        $player_details = PlayersDetail::where('banned','0')->get();
        $fileurl ='';
        if ($request->hasFile('notification_image')) {
            $notification_image = $request->file('notification_image');
            Storage::disk('local')->put('public/notification_image',$notification_image, 'public');
            $fileurl = url('storage/notification_image').'/'.$notification_image->hashName();
        }
        if(!empty($player_details)){
            self::notificationTopicsend($request->message, $request->title, $fileurl);
            
            // $device_tokens = array();
            // foreach ($player_details as $key => $value) {
            //     $device_tokens[]= $value->device_token;
            // }
            // if(count($device_tokens) > 0){                
                // self::notificationMultiplesend($request->message, $device_tokens, $request->title, $fileurl);
            // }
            
        }

        return redirect('/notification/send');

    }
}
