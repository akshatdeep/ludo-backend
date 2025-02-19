<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use App\Models\BoatControl;
use File;

class BoatControlController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $boat = BoatControl::orderBy('id','desc')->get();

            return Datatables::of($boat)
                ->addIndexColumn()
                ->editColumn('boat_status', function ($row) {
                    if($row->boat_status == '1'){
                        $action_buttons = '<span class="p-2 mb-2 bg-success text-white">On</span>';
                    }else{
                        $action_buttons = '<span class="p-2 mb-2 bg-warning text-white">Off</span>';
                    }
                    return $action_buttons;
                })
                ->addColumn('action', function ($row) {
                    $action_buttons = '<a href="' . route("boat_control.edit", $row->id) . '" data-toggle="tooltip" data-original-title="Edit" class="text-dark btn btn-success" data-toggle="tooltip" data-placement="right" title="Edit Boat" >Edit<i class="iconsmind-Pencil" ></i></a>';
                    // $action_buttons += '<a href="javascript:void(0)" onclick="deleteRow(' . $row->id . ')" class="text-dark btn btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Boat" style="color:#fff !important" >Delete<i class="fa fa-trash" ></i></a>';
                    return $action_buttons;
                })
                ->rawColumns(['action','boat_status'])
                ->make(true);
        }
        return view('boat_control.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if(!empty($request->id)){
            $boat = BoatControl::where('id', $request->id)->update([
                'boat_status' => $request->boat_status,
                'boat_complexity' => $request->boat_complexity            
            ]);
            
            notify()->success("Add Successfully!","Success","topRight");
            return redirect()->route('boat_control.list');
        } else{
            $boat = new BoatControl;
            $boat->boat_status = $request->boat_status;
            $boat->boat_complexity = $request->boat_complexity;
            $boat->save();    
            
            notify()->success("Updated Successfully!","Success","topRight");
            return redirect()->route('boat_control.list');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = BoatControl::find($id);
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = BoatControl::find($id);
        return view('boat_control.edit', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $boat = BoatControl::find($id);
        try{
            if(!empty($boat)){
                $boat->delete(); 
                return response()->json(['msg'=>'Deleted success'], 200);
            }
        }catch(\Exception $e){
            return response()->json(['msg'=>'Can not delete this boat'], 500);
        }  
        
        return response()->json(['msg'=>'Data Not success'], 500);
    }
}
