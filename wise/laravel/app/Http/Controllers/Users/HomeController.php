<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
        
    }
    public function admincontrol()
    {
        return view('/admincontrol/users/user-reg');
    }

    public function create(Request $request)
    {
        $validationRules =
            [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'contract'  => 'required',
            'creBy'     => 'required',
            //'statusstudent' => 'required|numeric',
        ];

        $customMessage = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'contract.required' => 'Contract is required',
            'creBy.required' => 'Contract is required',
        ];

        $tableData = [
            //'userid' => Auth::user()->id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'contract' => $request->input('contract'),
            //'status' => ,
            'type' => $request->input('creBy'),
            /*
        'name' => $request->input('elevel'),
        'designation' => $request->input('earea'),
        'salary' => $request->input('dname'),
        'status' => $request->input('iname'),
        'userid' => $request->input('iname'),
        'verified' => $request->input('iname'),
         */
        ];
        
        $validateFormData = request()->validate($validationRules, $customMessage);

        if (!$validateFormData) {
            return redirect()->back()->withErrors($request->all());
        }

        $insert = DB::table('users')
            ->insert($tableData);

        if (!$insert) {
            return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
        }

        return redirect()->route('adminregister')->with('msg', 'Inserted Successfully!');
    }


public function view(Request $request){

  $data['user'] = DB::table('users')
   ->select('*')
   ->paginate(10);
   return view('admincontrol.users.all-user',$data);

}

public function edit($id){

  $data['user'] = DB::table('users')
    ->where('id',"=",$id)
   ->first();
   return view('admincontrol.users.edit-user',$data);
}


public function update(Request $request,$id)
{   
    echo $id;
    die();
    //echo $request->input('hidden');
    $validationRules =
        [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'contract'  => 'required',
        //'statusstudent' => 'required|numeric',
    ];

    $customMessage = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'password.required' => 'Password is required.',
        'contract.required' => 'Contract is required',
    ];

    $tableData = [
        //'userid' => Auth::user()->id,
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'contract' => $request->input('contract'),
        //'status' => ,
        'type' => $request->input('creBy'),
        /*
    'name' => $request->input('elevel'),
    'designation' => $request->input('earea'),
    'salary' => $request->input('dname'),
    'status' => $request->input('iname'),
    'userid' => $request->input('iname'),
    'verified' => $request->input('iname'),
     */
    ];
    
    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
        return redirect()->back()->withErrors($request->all());
    }


    $update = DB::table('users')
    ->where('id', $id)
    ->update($tableData);

if (!$update) {
    return redirect()->back()->with('error', 'Information Not Updated!!');
}

return redirect()->route('edituser')->with('success', 'Information is Updated Successfully!');


/*
    $update = DB::table('users')
        ->where('id',"=",$id)
        ->update($tableData);

    if (!$update) {
        return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
    }

    return redirect()->route('home')->with('msg', 'Updated Successfully!');
*/
}

   

    public function delete($id){
        $delete= DB::table('users')
        ->where("id","=","$id")
        ->delete();

        if (!$delete) {
            return redirect()->back()->with('error', 'Not Deleted!!');
        }

        return redirect()->route('allusers')->with('msg', 'Deleted Successfully!');


    }

}
