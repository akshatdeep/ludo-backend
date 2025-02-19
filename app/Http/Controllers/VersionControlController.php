<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use App\Models\VersionControl;
use File;

class VersionControlController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $version_control = VersionControl::orderBy('id','desc')->get();

            return Datatables::of($version_control)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action_buttons = '<a href="' . route("version_control.edit", $row->id) . '" data-toggle="tooltip" data-original-title="Edit" class="text-dark btn btn-success" data-toggle="tooltip" data-placement="right" title="Edit Boat" >Edit<i class="iconsmind-Pencil" ></i></a>';
                    // $action_buttons += '<a href="javascript:void(0)" onclick="deleteRow(' . $row->id . ')" class="text-dark btn btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Boat" style="color:#fff !important" >Delete<i class="fa fa-trash" ></i></a>';
                   return $action_buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('version_control.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->id)){
            $version_control = VersionControl::where('id', $request->id)->update([
                'version_control' => $request->version_control,
                'app_link' => $request->app_link            
            ]);
            
            notify()->success("Add Successfully!","Success","topRight");
            return redirect()->route('version_control.list');
        } else{
            $version_control = new VersionControl;
            $version_control->version_control = $request->version_control;
            $version_control->app_link = $request->app_link;
            $version_control->save();    
            
            notify()->success("Updated Successfully!","Success","topRight");
            return redirect()->route('version_control.list');
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
        $data = VersionControl::find($id);
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
        $data = VersionControl::find($id);
        return view('version_control.edit', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $version_control = VersionControl::find($id);
        try{
            if(!empty($version_control)){
                $version_control->delete(); 
                return response()->json(['msg'=>'Deleted success'], 200);
            }
        }catch(\Exception $e){
            return response()->json(['msg'=>'Can not delete this version'], 500);
        }  
        
        return response()->json(['msg'=>'Data Not success'], 500);
    }
}
