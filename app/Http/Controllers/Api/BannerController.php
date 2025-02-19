<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BannerDetail;

class BannerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bannerList()
    {   
            $banner = BannerDetail::orderBy('id','desc')->where('status', 1)->get();
            
            foreach ($banner as $key => $value) {

                if ($value->category == 1) {
                    $category_label = 'Home';
                } else if ($value->category == 2) {
                    $category_label = 'Tournament';
                } else if ($value->category == 3) {
                    $category_label = '';
                } else if ($value->category == 4){
                    $category_label = '';
                } else{
                    $category_label = '';
                }

               $data['category_id'] = $value->category;
               $data['category_label'] = $category_label;
               $data['image'] = asset( 'banner/images/' . $value->image);

               $collection[] = $data;

            }
            $response = ['status'=>'Success','message'=>'Banner Listed Successfully ','data' => $collection];
            return response($response, 200);
    }
}
