<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendAndroidPushNotification( $message, $deviceToken, $title='Ludo app')
    {
        // start
        $apiAccessKey=Config::get('pushcredential.android');

        // $apiAccessKey="AAAAQvkh-NU:APA91bEcbb3oTpsaEacUDete4tlKzVf26hLHQTJfTfV3dmZVkgQX8yMSe4d84pIFWajtxdAEWAcR_PpDDie8GgJl4gIcg1xjoq14qG_EQgpEAvYCcyTIzDrS53OUWLthMgzlqflFC8-T";
        // dd($message);
        #prep the bundle
        $msgJson = array('body' => $message, 'title'	=> $title, 'icon'	=> 'myicon', 'sound' => 'mySound', 'key' => '');
        $fields = array('to' => $deviceToken, 'data'	=> $msgJson);
        $headers = array('Authorization: key=' . $apiAccessKey,'Content-Type: application/json');
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        // dd($result);
        return;
    }

    public function notificationMultiplesend($message, $tokenList, $title='Ludo app')
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $apiAccessKey=Config::get('pushcredential.android');
        $notification = [
            'title' => $title,
            'message'=>$message,
            'sound' => true,
        ];
        
        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];
 
        $headers = [
            'Authorization: key='.$apiAccessKey,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }

    public function notificationTopicsend($message, $title, $fileurl = '', $topic_name='ludo')
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverApiKey = Config::get('pushcredential.android');
 
        $messages = [
            'title' => $title,
            'message'=> $message,
            'fileurl'=> $fileurl,
            'sound' => true,
        ];

        $data = [            
            "to"=> "/topics/".$topic_name,
            'notification' => [
                    'title' => config('app.name'),
                    'data' => $messages
                ],

        ];
 
        $headers = [
            'Authorization: key='.$serverApiKey,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }



}
