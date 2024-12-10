<?php

namespace App\Http\Controllers\Salary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Models\Employee;
use Session;

class SalaryController extends Controller
{
  public function index(Request $request)
  {
    $year = $request->get("year");
    $month = $request->get("month");

    if ($year <= 0 && $month <= 0) {
      $thismonth = date('Y-m');
    } else {
      $thismonth =  "{$year}-" . (($month < 10) ? "0{$month}" : $month);
      Session::put('yearmonth', $thismonth);
    }

    $allEmployee = DB::table('salary')->select("employeeid")->where("date", "like", "$thismonth%")->get();
    $empId = array();
    foreach ($allEmployee as $emp) {
      $empId[] = $emp->employeeid;
    }

    $lastDayOfMonth = date('t', strtotime($thismonth));

    $data['employee'] =  DB::table('employees')
      ->select(
        'employees.id as empid',
        'employees.name as empname',
        'employees.designation as empdes',
        'employees.salary as empsalery',
        DB::raw("(select count(attendances.id) from attendances where attendances.employee_id=employees.id and attendances.status=2 and attendances.created_at>='$thismonth-01 00:00:00' and attendances.created_at <= '$thismonth-$lastDayOfMonth 23:59:59') as late"),
        DB::raw("(select count(attendances.id) from attendances where attendances.employee_id=employees.id and attendances.status=3 and attendances.created_at>='$thismonth-01 00:00:00' and attendances.created_at <= '$thismonth-$lastDayOfMonth 23:59:59') as absent"),
        DB::raw("(select count(attendances.id) from attendances where attendances.employee_id=employees.id and attendances.status=1 and attendances.created_at>='$thismonth-01 00:00:00' and attendances.created_at <= '$thismonth-$lastDayOfMonth 23:59:59' and attendances.overtime=0) as present"),
        DB::raw("(select count(attendances.id) from attendances where attendances.employee_id=employees.id and attendances.status=1 and attendances.created_at>='$thismonth-01 00:00:00' and attendances.created_at <= '$thismonth-$lastDayOfMonth 23:59:59' and attendances.overtime=1) as ot")
      )
      ->whereNotIn('employees.id', $empId)
      ->where("status", 1)
      ->where("created_at", "<", $thismonth . "-30")
      ->get();

    $data['allAdvance'] =  DB::table('advances')
      ->select(
        "advances.employee_id",
        DB::raw("(select sum(adv.amount) from advances as adv where adv.employee_id = advances.employee_id) as amount"),
        DB::raw("(select sum(salary.advance) from salary where salary.employeeid = advances.employee_id) as advance"),
        "advances.installment_amount",
        "advances.installment"
      )
      ->get();

    $data['allEmployeeCredit'] = DB::table('transaction')
      ->select('employee_id', DB::raw("SUM(amount) as eCredit"))
      ->where("type", "=", 4)
      ->where('date', '>=', '2024-07-05')
      ->groupBy('employee_id')
      ->get();

    $data['allEmployeeDebit'] = DB::table('transaction')
      ->select('employee_id', DB::raw("SUM(amount) as eDebit"))
      ->where("type", "=", 5)
      ->where('date', '>=', '2024-07-05')
      ->groupBy('employee_id')
      ->get();

    $data['allReturn'] = DB::table('salary')
      ->select('employeeid', DB::raw("SUM(credit_adjust) as totalPaid"))
      ->where('date', '>=', '2024-07-01')
      ->groupBy('employeeid')
      ->get();



    if ($data['employee']) {
      $data['title'] = "Insert Salary";
      return view('admincontrol.salary.create-salary', $data);
    } else {
      $data['nodata'] = "No Data Found";
      return view('admincontrol.salary.create-salary', $data);
    }
  }

  public function create(Request $request)
  {
    $status = $request->input("status");
    foreach ($status as $st) {
      $tableData[] = array(
        "employeeid" => $st,
        'date'      => $request->input("yearmonth") . "-" . "01",
        "amount"    => (DB::table('employees')->select("salary")->where("id", $st)->first())->salary,
        "bonus"     => $request->input("bonus_{$st}"),
        "overtime"     => $request->input("ot_{$st}"),
        'advance'    => $request->input("adv_{$st}"),
        'penalty'    => $request->input("penalty_{$st}"),
        'credit_adjust'    => $request->input("cre_{$st}"),
        'usersid'    => Auth::user()->id,
        'verified' => 0,
        'created_at' => date('Y-m-d'),
      );
    }

    $insert = DB::table('salary')
      ->insert($tableData);


    if (!$insert) {
      return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
    }
    return redirect()->back()->with('msg', 'Inserted Successfully!');
  }

  public function print(Request $request)
  {
    $data['month'] =   $request->get("month");
    $data['year'] =   $request->get("year");
    $data['results'] = "";

    if ($data['month'] && $data['year']) {
      $data['results'] = DB::table('salary')
        ->join('employees', 'salary.employeeid', '=', 'employees.id')
        ->select('salary.*', 'employees.id as empid', 'employees.name as empname')
        ->where('salary.date', 'like', "{$data['year']}-{$data['month']}%")
        ->where('salary.status', '=', 1)
        ->get();
    }




    return view('admincontrol.salary.print-salary', $data);
  }

  public function view(Request $request)
  {
    $sdate =   $request->get("sdate");
    $edate =   $request->get("edate");

    if ($sdate == "" && $edate == "") {
      $data['edtsalary'] = DB::table('salary')
        ->join('employees', 'salary.employeeid', '=', 'employees.id')
        ->join('users', 'salary.usersid', '=', 'users.id')
        ->select('salary.*', 'employees.id as empid', 'employees.name as empname', 'users.id as uid', 'users.name as uname')
        ->where('salary.status', '=', 1)
        ->paginate(30);
      $data['title'] = "View Active Salary";
      return view('admincontrol.salary.view-all-salary', $data);
    } else {
      $query = DB::table('salary')
        ->join('employees', 'salary.employeeid', '=', 'employees.id')
        ->join('users', 'salary.usersid', '=', 'users.id')
        ->select('salary.*', 'employees.id as empid', 'employees.name as empname', 'users.id as uid', 'users.name as uname')
        ->where('salary.status', '=', 1);

      if ($sdate && $edate) {
        $query->where("salary.created_at", ">=", $sdate);
        $query->where("salary.created_at", "<=", $edate);
      } else if ($sdate) {
        $query->where("salary.created_at", $sdate);
      } else if ($edate) {
        $query->where("salary.created_at", $edate);
      }
      $data['edtsalary'] = $query->get();
      $data['title'] = "Search Active Salary";
      return view('admincontrol.salary.view-result-all-salary', $data);
    }
  }

  public function viewfrozen(Request $request)
  {
    $sdate =   $request->get("sdate");
    $edate =   $request->get("edate");

    if ($sdate == "" && $edate == "") {
      $data['edtsalary'] = DB::table('salary')
        ->join('employees', 'salary.employeeid', '=', 'employees.id')
        ->join('users', 'salary.usersid', '=', 'users.id')
        ->select('salary.*', 'employees.id as empid', 'employees.name as empname', 'users.id as uid', 'users.name as uname')
        ->where('salary.status', '=', 0)
        ->paginate(30);
      $data['title'] = "View Frozen Salary";
      return view('admincontrol.salary.view-all-frozen-salary', $data);
    } else {
      $query = DB::table('salary')
        ->join('employees', 'salary.employeeid', '=', 'employees.id')
        ->join('users', 'salary.usersid', '=', 'users.id')
        ->select('salary.*', 'employees.id as empid', 'employees.name as empname', 'users.id as uid', 'users.name as uname')
        ->where('salary.status', '=', 0);

      if ($sdate && $edate) {
        $query->where("salary.created_at", ">=", $sdate);
        $query->where("salary.created_at", "<=", $edate);
      } else if ($sdate) {
        $query->where("salary.created_at", $sdate);
      } else if ($edate) {
        $query->where("salary.created_at", $edate);
      }
      $data['edtsalary'] = $query->get();
      $data['title'] = "Search Frozen Salary";
      return view('admincontrol.salary.view-result-all-salary', $data);
    }
  }

  public function edit($id)
  {
    $data['salary'] =  DB::table('salary')
      ->select('*')
      ->where('id', '=', "$id")
      ->first();

    $data['employee'] = DB::table('employees')
      ->select('id', 'name')
      ->get();
    $data['bank'] = DB::table('banks')
      ->select('id', 'name')
      ->get();
    $data['user'] = DB::table('users')
      ->select('id', 'name')
      ->get();
    $data['title'] = "Update Salary";
    return view('admincontrol.salary.edit-salary', $data);
  }

  public function update(Request $request, $id)
  {

    $tableData = [
      'employeeid' => $request->input('empName'),
      'date'      => date('Y-m-d H:i:s'),
      'amount'    => $request->input('amount'),
      'overtime'    => $request->input('overtime'),
      'bonus'    => $request->input('bonus'),
      'penalty'    => $request->input('penalty'),
      //'status' => 1,
      //'bankid'    => $request->input('bankName'),
      'usersid'    => Auth::user()->id,
      'verified' => 0,
      'created_at' => date('Y-m-d H:i:s'),
    ];



    $update = DB::table('salary')
      ->where('id', '=', "$id")
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Invalid information, Not Updated!!');
    }
    return redirect()->back()->with('msg', 'Updated Successfully!');
  }

  public function delete($id)
  {
    /*
    $delete = DB::table('salary')
    ->where('id','=',"$id")
    ->delete();
    if(!$delete){
    return redirect()->back()->with('error','Not Deleted!');
  }
  return redirect()->back()->with('msg','Deleted Successfully!');

}*/
    return redirect()->back();
  }
  public function fridge($id)
  {
    $tableData = [
      'verified' => 0
    ];
    $update = DB::table('salary')
      ->where('id', '=', "$id")
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Not Unfridge!');
    }
    return redirect()->back()->with('msg', 'Unfridge Successfully!');
  }
}
