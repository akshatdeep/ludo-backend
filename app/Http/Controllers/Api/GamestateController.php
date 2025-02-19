<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gamestate;
use App\User;
use Illuminate\Support\Facades\Validator;

use File;

class GamestateController extends Controller
{
   

    public function roomCreate(Request $request)
    {
        $game = Gamestate::create([
        'roomid' => $request->room_id,
        'state'=> $request->state
        ]);

        $response = ['status'=>'Success'];
        return response($response, 200);
    }
       
   
    
    
    
    public function roomUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

         
            $room = Gamestate::where('roomid', $request->room_id)->first();
           if ($room) {
               
               $game = Gamestate::where('roomid',$request->room_id)->update([
                'state'    => $request->state,
            ]);
               
          $response = ['status'=>'success'];  
        return response($response, 200); 
           }
           else{
               
               $response = ['status'=>'fail'];
        return response($response, 200); 
           }

    }

  

    public function roomState(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'room_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

         
            $room = Gamestate::where('roomid', $request->room_id)->first();
           if ($room) {
               
            
               
          $response = ['status'=>'success','room'=>$room];  
        return response($response, 200); 
           }
           else{
               
               $response = ['status'=>'fail'];
        return response($response, 200); 
           }
    }
}
