<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\Category;

class HomeScreenController extends Controller
{
    private $settings;
    public function __construct() {
        $this->settings = DB::table('settings')->select('time_zone', 'job_limit')->first();
    }
    public function job_list($start){
         $data = DB::table("jobs")
        ->select(
                    'jobs.id',
                    'jobs.title',
                    'jobs.job_type',
                    'jobs.price',
                    'locations.name as lname',
                    'locations.zip',
                    'categories.picture'
                )
        ->join('locations', 'locations.id', '=', 'jobs.locations_id')
        ->join('categories', 'categories.id', '=', 'jobs.categories_id')
        ->skip($start)->take($this->settings->job_limit)
        ->orderBy("id", "desc")
        ->get();

        return response()->json($data);

    }

    public function category(Request $request){
        $data['categoryList'] = DB::table("categories")
            ->select('id', 'name', 'spanish_name', 'picture')
        ->where('status', 1)
        ->orderBy("serial", "asc")
        ->get();

        $data['locationList'] = DB::table("locations")
        ->select('id','name')
        ->orderBy("name", "asc")
        ->get();

         $data['jobList'] = DB::table("jobs")
        ->select('*')
        ->orderBy("id", "desc")
        ->get();

        return response()->json($data);

    }

    public function house_keepings($id){
        $data['houseKeepingList'] = DB::table("house_keepings")
        ->select('id','name', 'min_val', 'max_val', 'default_val')
        ->where('category_id', $id)
        ->orderBy("name", "asc")
        ->get();

        $data['houseKeepingRadioList'] = DB::table("house_keeping_radios")
        ->select('id','posting_title', 'display_title', 'label_list')
        ->where('category_id', $id)
        ->orderBy("serial", "asc")
        ->get();
        return response()->json($data);
    }

    public function location(){
        $data['locationsList'] = DB::table("locations")
        ->select('id','name', 'zip')
        ->where('status', 1)
        ->orderBy("name", "asc")
        ->get();

        $data['skillList'] = DB::table("skills")
        ->select('id','name')
        ->where('status', 1)
        ->orderBy("name", "asc")
        ->get();
        return response()->json($data);
    }

    public function settings(){
        return response()->json($this->settings);
    }

     public function category_search($keyword) {
        $data = DB::table("categories")
            ->select('id', 'name', 'spanish_name', 'picture')
        ->where('status', 1)
        ->where('name', 'like', "%{$keyword}%")
        ->orderBy("serial", "asc")
        ->get();

        return response()->json($data);
     }
}
