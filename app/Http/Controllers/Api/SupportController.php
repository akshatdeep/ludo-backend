<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportDetail;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    /**
     * Customer Contact Us Save function for Customer App
     *
     * @param Request $request
     * @return json
     * @method ticketRefNumber()
     * @copyright 2020 Colan
     */
    public function supportRequestAdd(Request $request){
       
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            'player_phone' => 'required',
            'email_id' => 'required',
            'subject' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
            $contactUs = new SupportDetail;
                $contactUs->player_id       = $request->player_id;
                $contactUs->player_name     = $request->player_name;
                $contactUs->player_phone    = $request->player_phone;
                $contactUs->email_id        = $request->email_id;
                $contactUs->subject         = $request->subject?$request->subject:"";
                $contactUs->message         = $request->message?$request->message:"";
                $contactUs->status          = 1;
            $contactUs->save();

        if($contactUs->id){
            $response = ['status'=>'Success','message'=>'We will back to you shortly','data' => $contactUs];
            return response($response, 200);
        }
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function supportList($id)
    {   
        $supportDetail = SupportDetail::where('player_id',$id)->orderBy('id','desc')->get();

        $response = ['status'=>'Success','message'=>'Support Listed Successfully','data' => $supportDetail];
        return response($response, 200);
    }
}
