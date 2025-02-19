<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use App\Models\BannerDetail;
use File;

class BannerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $banner = BannerDetail::orderBy('id','desc')->get();

            return Datatables::of($banner)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action_buttons = '<a href="' . route("bannerEdit", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-success" data-toggle="tooltip" data-placement="right" title="Edit Banner" >Edit<i class="iconsmind-Pencil" ></i></a><a href="' . route("bannerdelete", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Banner" style="color:#fff !important" >Delete<i class="fas fa-trash" ></i></a>';
                    return $action_buttons;
                })
                ->addColumn('image', function ($row) {
                    $image = '<img width="50" src="'.asset( 'banner/images/' . $row->image).'" alt="'.$row->image.'" class="img-thumbnail uploaded_image m-t-20"/>';
                    return $image;
                })

                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('banner.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = new BannerDetail;
        $action = "0";
        return view('banner.create',compact('banner','action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $todayTime          = Carbon::now();

        if($request->hasFile('image')) {
            $destinationPath    = public_path('/banner/images');

            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $image              = $request->file('image');
            $imagename          = date('d-m-Y-H-i').$image->getClientOriginalName();
            $imagePath          = $destinationPath . "/" . $imagename;
            $image->move($destinationPath, $imagename);
        }
        $banner = new BannerDetail;
            $banner->category        = "1";
            $banner->image             = $imagename;

        $banner->save();

        if($banner->id){
            notify()->success("Banner is created successfully","Success","topRight");
            return view('/banner/list');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = BannerDetail::where('id',$id)->first();
        $action            = "1";
        return view('banner.create',compact('banner','action'));
    }

    public function delete($id)
    {
        $banner = BannerDetail::where('id',$id)->delete();
        // $action            = "1";
        return view('/banner/list');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){

        if ($request->hasFile('image')) {
            $destinationPath    = public_path('/banner/images');

            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $image              = $request->file('image');
            $imagename          = date('d-m-Y-H-i').$image->getClientOriginalName();
            $imagePath          = $destinationPath . "/" . $imagename;
            $image->move($destinationPath, $imagename);
        } else{
            $imagename = BannerDetail::where('id',$id)->value('image');
        }

        $banner = BannerDetail::where('id', $id)->update([
            'category'       => $request->category,
            'image'          => $imagename,

        ]);

        if($banner){
            notify()->success("Banner is Update successfully","Success","topRight");
            return view('/banner/list');
        }
    }
}
