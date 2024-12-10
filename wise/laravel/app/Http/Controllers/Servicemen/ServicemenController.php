<?php

namespace App\Http\Controllers\Servicemen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServicemenController extends Controller
{
    public function index()
    {
        $data['title'] = "Insert Service Man";
        $data['customer'] = DB::table('customers')
        ->select('*')
        ->where('status','=',1)
        ->get();
        return view('admincontrol.servicemen.create-service',$data);
    }

    public function create(Request $request)
    {
                $validationRules =
                [
                'title' => 'required|max:100',
                'cost' => 'required|numeric|min:1',
                'earning' => 'required|numeric|min:1',
                'customerid' => 'required|numeric|min:1',
                'date' => 'required',
                /*
                'password' => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'*/
                //'statusstudent' => 'required|numeric',
            ];

            $customMessage = [
                'title.required' => 'Title  is required.',
                'cost.required' => 'Cost is required.',
                'cost.required|numeric|min:1' => 'Cost is must be number.',
                'earning.required' => 'Earning is required.',
                'earning.required|numeric|min:1' => 'Earning is must be number.',
                'customerid.required' => 'Customer Name is required.',
                'customerid.required|numeric|min:1' => 'Customer Name is must be number.',
                'date.required' => 'Created Date is required.',
            ];

            $tableData = [
                'title' => $request->input('title'),
                'cost' => $request->input('cost'),
                'earning' => $request->input('earning'),
                'date'      => date('Y-m-d H:i:s'),
                'customerid'    => $request->input('customerid'),
                'created_at' => $request->input('date'),
                /*
                'payment_method'    => $request->input('payment_method'),
                'status' => 1,
                'date'      => date('Y-m-d H:i:s'),  
                'usersid'    =>Auth::user()->id,
                'verified' => 0,
                */
            ];

            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $insert = DB::table('service_men')
                ->insert($tableData);

            if (!$insert) {
                return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
            }
            return redirect()->back()->with('msg', 'Inserted Successfully!');

    }

    public function view()
    {
        $data['title'] = "Active Service Man";
        $data['service'] = DB::table('service_men')
        ->join('customers','service_men.customerid','=','customers.id')
        ->select('service_men.*','customers.id as cusid','customers.contact_person as cusname')
        ->where('service_men.status','=',1)
        ->paginate(10);
        return view('admincontrol.servicemen.view-servicemen',$data);
    }
    public function frozen()
    {
        $data['title'] = "Frozen Service Man";
        $data['service'] = DB::table('service_men')
        ->join('customers','service_men.customerid','=','customers.id')
        ->select('service_men.*','customers.id as cusid','customers.contact_person as cusname')
        ->where('service_men.status','=',0)
        ->paginate(10);
        return view('admincontrol.servicemen.fridge-servicemen',$data);
    }

    

    public function edit($id)
    {   
        $data['title'] = "Update Service Man";
        $data['customer'] = DB::table('customers')
        ->select('*')
        ->get();

        $data['sermen'] =  DB::table('service_men')
        ->where('id','=',"$id")
        ->first();
        return view('admincontrol.servicemen.edit-service',$data);
    }

    public function update(Request $request,$id)
    {
                $validationRules =
                [
                'title' => 'required',
                'cost' => 'required|numeric|min:1',
                'earning' => 'required|numeric|min:1',
                'customerid' => 'required|numeric|min:1',
                'date' => 'required',
                /*
                'password' => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'*/
                //'statusstudent' => 'required|numeric',
            ];

            $customMessage = [
                'title.required' => 'title  is required.',
                'cost.required' => 'Cost is required.',
                'cost.required|numeric|min:1' => 'Cost is must be number.',
                'earning.required' => 'Earning is required.',
                'earning.required|numeric|min:1' => 'Earning is must be number.',
                'customerid.required' => 'Customer Name is required.',
                'customerid.required|numeric|min:1' => 'Customer Name is must be number.',
                'date.required' => 'Created Date is required.',
            ];

            $tableData = [
                'title' => $request->input('title'),
                'cost' => $request->input('cost'),
                'earning' => $request->input('earning'),
                'date'      => date('Y-m-d H:i:s'),
                'customerid'    => $request->input('customerid'),
                'updated_at' => $request->input('date'),
                /*
                'payment_method'    => $request->input('payment_method'),
                'status' => 1,
                'date'      => date('Y-m-d H:i:s'),  
                'usersid'    =>Auth::user()->id,
                'verified' => 0,
                */
            ];

            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $update = DB::table('service_men')
                ->where('id','=',"$id")
                ->update($tableData);

            if (!$update) {
                return redirect()->back()->with('error', 'Invalid information, Not Update!!');
            }
            return redirect()->route('viewservicemen')->with('msg', 'Update Successfully!');

    }

   

    public function delete($id)
    {
         /*
        if(Auth::user()->type == 1 && $data['user']->verified == 1){
            return redirect()->route('viewexpense');
        }
        */

        $delete = DB::table('service_men')
        ->where('id','=',"$id")
        ->delete();
        if(!$delete){
           return redirect()->back()->with('error','Not Deleted!');
        }
        return redirect()->back()->with('msg','Deleted Successfully!');
    
    
    }
    public function fridge($id)
    {
         /*
        if(Auth::user()->type == 1 && $data['user']->verified == 1){
            return redirect()->route('viewexpense');
        }
        */
        $tableData = [
            'status' => 0
        ];

        $update = DB::table('service_men')
        ->where('id','=',"$id")
        ->update($tableData);

        if (!$update) {
        return redirect()->back()->with('error', 'Invalid information, Not Fridge!!');
    }
    return redirect()->route('viewservicemen')->with('msg', 'Fridge Successfully!');
    
    
    }
    public function active($id)
    {
         /*
        if(Auth::user()->type == 1 && $data['user']->verified == 1){
            return redirect()->route('viewexpense');
        }
        */
        $tableData = [
            'status' => 1
        ];

        $update = DB::table('service_men')
        ->where('id','=',"$id")
        ->update($tableData);

        if (!$update) {
        return redirect()->back()->with('error', 'Invalid information, Not Actived!!');
    }
    return redirect()->route('viewservicemen')->with('msg', 'Actived Successfully!');
    
    
    }

}
