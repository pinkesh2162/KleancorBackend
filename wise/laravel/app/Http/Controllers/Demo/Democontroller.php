<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class Democontroller extends Controller
{
    public function index(){
       
        $data['product'] = DB::table('products')
             ->select('*')
             ->get();

        return view('/admincontrol/demo/demo-page', $data);
    }
    
    public function create(Request $request){
      $data = array();
      return view('/admincontrol/demo/demo-page-2', $data);
    }

}