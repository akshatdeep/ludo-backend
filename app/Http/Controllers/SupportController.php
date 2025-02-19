<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SupportDetail;
use DataTables;

class SupportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $supportRequest = SupportDetail::orderBy('id','desc')->where('status',1)->with('playerId')->get();
            return Datatables::of($supportRequest)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action_buttons = '<a style="background: #28a745;color: #fff !important; margin-right:10px;" href="' . route("supportRequestEdit", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-lg" data-toggle="tooltip" data-placement="right" title="Reply" >Reply</a>';
                    $action_buttons .= '<a style="background: #f00;color: #fff !important;" href="' . route("supportRequestReject", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-lg" data-toggle="tooltip" data-placement="right" title="Close Request" >Close</a>';
                    return $action_buttons;
                })
                ->addColumn('player_name', function ($row) {
                    return $row->playerId->first_name;
                })

                ->rawColumns(['action','player_name'])
                ->make(true);
        }
        return view('support.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){

        $todayTime  = Carbon::now();
        $support_request = SupportDetail::where('id', $id)->first();
        // $walletDetail = WalletDetail::where('player_id',$request->player_id)->first();


        $details = SupportDetail::where('id', $id)->update([
            'status'                     => 2,
            'admin_reply'                     => $request->admin_reply ? $request->admin_reply :'',
        ]);

        if($details){
            notify()->success("Reply Submited","Success","topRight");
            return redirect()->route('support.list');
            // return view('/support/request/list');
            // return redirect('/support/request/list')->with(['Success'=>'Withdraw is request Rejected']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request,$id){


        $details = SupportDetail::where('id', $id)->update([
            'status'          => 2,
        ]);

        if($details){
            notify()->success("Request Rejected","Success","topRight");
            return redirect()->route('support.list');

            // return redirect('/support/request/list')->with(['Success'=>'Withdraw is request Rejected']);
        }
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id){


        $supportData = SupportDetail::where('id',$id)->with('playerId')->first();
        $action            = "1";
        return view('support.accept',compact('supportData','action'));
    }

    

}
