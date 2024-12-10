<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Classes\CommonClasses;

class SalesController extends Controller
{
   public function index()
   {
       $data['customer'] = DB::table('customers')
                        ->select("*")
                        ->get();
       $data['project'] = DB::table('projects')
                        ->select("*")
                        ->get();

    $data['title'] = "Insert Sells";
        return view('admincontrol.sales.sells-create',$data);
   } 
   public function view()
   {

    $data['prjct'] = DB::table('sales')
    ->join('customers', 'sales.customerid', '=', 'customers.id')
    ->join('projects', 'sales.projectid', '=', 'projects.id')
    ->join('users', 'sales.usersid', '=', 'users.id')
     ->select('sales.*','customers.contact_person','projects.project_name as proname','projects.customerid as proid','users.name')
     ->paginate(30);
    $data['title'] = "View Sells";
     return view('admincontrol.sales.view-all-sales-prod',$data);
   }
   public function edit($id)
   {
       echo $id;
   } 
   public function update(Request $request, $id)
   {
       echo $id;
   } 
   public function delete($id)
   {
       echo $id;
   } 
   
}
