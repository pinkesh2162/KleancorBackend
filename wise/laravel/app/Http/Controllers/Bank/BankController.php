<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
  public function index()
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['title'] = "Insert Bank Acc";

    return view('admincontrol.bank.add-bank', $data);
  }

  public function create(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $validationRules =
      [
        'name' => 'required|max:100',
        'accountno' => 'required|max:30',
        'branch' => 'required|max:100',
        'balanch' => 'required|numeric',
        'date' => 'required',
      ];

    $customMessage = [
      'name.required' => 'Bank Name is required.',
      'accountno.required' => 'Account No is required.',
      'branch.required' => 'Branch is required.',
      'balanch.required' => 'Balanch is required',
      'date.required' => 'Created Date is required',
    ];

    $tableData = [
      'name' => $request->input('name'),
      'account_no' => $request->input('accountno'),
      'branch' => $request->input('branch'),
      'balanch' => $request->input('balanch'),
      'created_at' => $request->input('date'),
    ];

    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $insert = DB::table('banks')->insert($tableData);

    if (!$insert) {
      return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
    }
    return redirect()->back()->with('msg', 'Inserted Successfully!!');
    //return redirect()->route('adminregister')->with('msg', 'Inserted Successfully!');
  }

  public function view()
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['bank']  = DB::table('banks')
      ->select('*')
      ->where('status', 1)
      ->paginate(30);

    $data['title'] = "Active Bank Acc";

    return view('admincontrol.bank.view-all-bank', $data);
  }
  public function frozen()
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['bank']  = DB::table('banks')
      ->select('*')
      ->where('status', 0)
      ->paginate(30);
    $data['title'] = "Frozen Bank Acc";
    return view('admincontrol.bank.view-frozen-bank', $data);
  }

  public function edit($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['bank'] = DB::table('banks')
      ->where('id', "=", "$id")
      ->first();
    $data['title'] = "Update Bank Acc";
    return view('admincontrol.bank.eidt-bank', $data);
  }

  public function update(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }

    $validationRules =
      [
        'name' => 'required|max:100',
        'accountno' => 'required|max:30',
        'branch' => 'required|max:100',
        'balanch' => 'required|numeric',
        'date'  => 'required',
      ];

    $customMessage = [
      'name.required' => 'Bank Name is required.',
      'accountno.required' => 'Account No is required.',
      'branch.required' => 'Branch is required.',
      'balanch.required' => 'Balanch is required',
      'date'  => 'Created Date is required',
    ];

    $tableData = [
      'name' => $request->input('name'),
      'account_no' => $request->input('accountno'),
      'branch' => $request->input('branch'),
      'balanch' => $request->input('balanch'),
      'updated_at' => $request->input('date'),
    ];

    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $update = DB::table('banks')
      ->where('id', '=', "$id")
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Invalid information, Not Updated!!');
    }
    return redirect()->route('allviewbank')->with('msg', 'Updated Successfully!!');
    //return redirect()->route('adminregister')->with('msg', 'Inserted Successfully!');

  }

  public function delete($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $tableData = [
      'status' => 0
    ];
    $update = DB::table('banks')
      ->where('id', '=', "$id")
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Invalid information, Not Frozen!!');
    }
    return redirect()->back()->with('msg', 'Frozen Successfully!!');
    //return re
  }

  public function active($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $tableData = [
      'status' => 1
    ];
    $update = DB::table('banks')
      ->where('id', '=', "$id")
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Invalid information, Not Active!!');
    }
    return redirect()->back()->with('msg', 'Active Successfully!!');
    //return re
  }
}
