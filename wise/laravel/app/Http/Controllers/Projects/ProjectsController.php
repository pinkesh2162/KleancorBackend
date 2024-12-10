<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Console\Presets\React;

class ProjectsController extends Controller
{
    public function index(){
      
        $data['customerId'] = DB::table('customers')
        ->select('*')
        ->where('status','=',1)
        ->get();
               
        /*
        $data['customerId'] = DB::table('projects')
            ->join('customers', 'projects.customerId', '=', 'customers.id')
            ->select('projects.*','customers.id as custid','customers.company_name as compname','customers.contact_person as contperson','customers.contact_number as cuscontnum')
            ->get();
         */
        $data['title'] = "Insert Project";
        return view('admincontrol.projects.create-project',$data);
    }

    public function insert(Request $request)
    {
            $validationRules =
            [
            'pname' => 'required|max:100',
            'creBy' => 'required',
            'date' => 'required',
            /*
            'email' => 'required',
            'contract' => 'required',
            'creBy' => 'required',
            'password' => 'min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'*/
            //'statusstudent' => 'required|numeric',
        ];

        $customMessage = [
            'pname.required' => 'Project Name is required.',
            'creBy.required' => 'Customer Name is required.',
            'date.required' => 'Created Date is required.',
            /*
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'password.required' => 'Password and Contirm password is not match!.',
            'contract.required' => 'Contract is required',
            'creBy.required' => 'Contract is required',*/
        ];

        $tableData = [
            'project_name' =>$request->input('pname'),
            'customerid' => $request->input('creBy'),
            'date'      => $request->input('date'),
            'status' => 1,
            'verified' => 0,
            'created_at' => date('Y-m-d'),
            ];

            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $insert = DB::table('projects')
                ->insert($tableData);

            if (!$insert) {
                return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
            }
            return redirect()->back()->with('msg', 'Inserted Successfully!');
        // return redirect()->route('adminregister')->with('msg', 'Inserted Successfully!');
    }


    public function view()
    {
        $data['title'] = "Active Project";

       $data['prjct'] = DB::table('projects')
       ->join('customers', 'projects.customerid', '=', 'customers.id')
        ->select('projects.*','customers.contact_person')
        ->where('projects.status','=',1)
        ->paginate(10);

        return view('admincontrol.projects.view-all-project',$data);
    }
    public function frozen()
    {
        $data['title'] = "Frozen Project";

       $data['prjct'] = DB::table('projects')
       ->join('customers', 'projects.customerid', '=', 'customers.id')
        ->select('projects.*','customers.contact_person')
        ->where('projects.status','=',0)
        ->paginate(10);

        return view('admincontrol.projects.view-frozen-project',$data);
    }

    public function edit($id)
    {   
        $data['title'] = "Update Project";

        $data['customerId'] = DB::table('customers')
        ->select('*')
        ->where('status','=',1)
        ->get();

        $data['prjctedit'] = DB::table('projects')
        ->where('id','=',$id)
        ->first();

        if(Auth::user()->type == 1 && $data['prjctedit']->verified == 1){
            return redirect()->route('viewprojects');
        }

        return view('admincontrol.projects.edit-project',$data);
    }

    public function update(Request $request, $id)
    { 
        $data['prjct'] = DB::table('projects')
            ->where('id', "=", $id)
            ->first();
            if(Auth::user()->type == 1 && $data['prjct']->verified == 1){
                return redirect()->route('viewprojects');
            }

                $validationRules =
                [
                'pname' => 'required|max:100',
                'creBy' => 'required',
                'date' => 'required',
                /*
                'email' => 'required',
                'contract' => 'required',
                'creBy' => 'required',
                'password' => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'*/
                //'statusstudent' => 'required|numeric',
            ];

            $customMessage = [
                'pname.required' => 'Project Name is required.',
                'creBy.required' => 'Customer Name is required.',
                'date.required' => 'Created Date is required.',
                /*
                'email.required' => 'Email is required.',
                'password.required' => 'Password is required.',
                'password.required' => 'Password and Contirm password is not match!.',
                'contract.required' => 'Contract is required',
                'creBy.required' => 'Contract is required',*/
            ];

            $tableData = [
                'project_name' =>$request->input('pname'),
                'customerid' => $request->input('creBy'),
                'date'      => $request->input('date'),
                'status' => 1,
                'verified' => 0,
                'updated_at' => date('Y-m-d'),
            ];

            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $update = DB::table('projects')
                ->where('id','=',"$id")
                ->update($tableData);

            if (!$update) {
                return redirect()->back()->with('error', 'Invalid information, Not Update!!');
            }
            return redirect()->route('viewprojects')->with('msg', 'Update Successfully!');
    }

    public function delete($id)
    {
        $data['prjctedit'] = DB::table('projects')
        ->where('id','=',$id)
        ->first();
        if(Auth::user()->type == 1 && $data['prjctedit']->verified == 1){
            return redirect()->route('viewprojects');
        }

        $delete = DB::table('projects')
        ->where('id','=',"$id")
        ->delete();
        if(!$delete){
           return redirect()->back()->with('error','Not Deleted!');
        }
        return redirect()->route('viewprojects')->with('msg','Deleted Successfully!');

    }

    public function fridge($id)
    {
        $data['prjctedit'] = DB::table('projects')
        ->where('id','=',$id)
        ->first();
        if(Auth::user()->type == 1 && $data['prjctedit']->verified == 1){
            return redirect()->route('viewprojects');
        }
    $updateTableData = [
        'status' => 0,
        'verified' => 0
    ];
        $update = DB::table('projects')
        ->where('id','=',"$id")
        ->update($updateTableData);
        if(!$update){
           return redirect()->back()->with('error','Not Frozen!');
        }
        return redirect()->route('viewprojects')->with('msg','Frozen Successfully!');

    }
    public function active($id)
    {
        $data['prjctedit'] = DB::table('projects')
        ->where('id','=',$id)
        ->first();
        if(Auth::user()->type == 1 && $data['prjctedit']->verified == 1){
            return redirect()->route('viewprojects');
        }
    $updateTableData = [
        'status' => 1,
        'verified' => 0
    ];
        $update = DB::table('projects')
        ->where('id','=',"$id")
        ->update($updateTableData);
        if(!$update){
           return redirect()->back()->with('error','Not Active!');
        }
        return redirect()->route('viewprojects')->with('msg','Active Successfully!');

    }


}
