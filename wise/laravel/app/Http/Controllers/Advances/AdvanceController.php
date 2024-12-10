<?php

namespace App\Http\Controllers\Advances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AdvanceController extends Controller
{
  public function index()
  {
    $data['title'] = "Insert Advance";
    $data['allEmp'] = DB::table("employees")->where("status", 1)->get();
    return view('admincontrol.advance.index', $data);
  }
  public function create(Request $request)
  {
    $sdata = [
      "employee_id" => $request->employee_id,
      "amount" => $request->amount,
      "installment" => $request->installment
    ];

    DB::table("advances")->insert($sdata);
    return redirect()->back()->with("msg", "Advance save successfully");
  }

  public function show(Request $request)
  {
    $data['title'] = "Advance View";
    $data['allData'] = DB::table("advances")
      ->select(
        "employees.name",
        DB::raw('(select sum(adv.amount) from advances as adv where adv.employee_id = advances.employee_id) as totalAdvance'),
        DB::raw('(select sum(salary.advance) from salary where salary.employeeid = advances.employee_id) as totalPaid')
      )
      ->join("employees", "employees.id", "=", "advances.employee_id")
      ->groupBy('employees.name', 'advances.employee_id')
      ->orderBy("employees.name", 'asc')
      ->get();

    return view('admincontrol.advance.view', $data);
  }
}
