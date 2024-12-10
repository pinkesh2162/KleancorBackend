<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
  public function index()
  {
    $data['title'] = "Insert Attendance";
    $data['allEmp'] = DB::table("employees")->where("status", 1)->get();
    return view('admincontrol.attendance.index', $data);
  }

  public function create(Request $request)
  {
    $ids = $request->input("ids");
    $status = $request->input("status");
    $allEmp = DB::table("employees")->where("status", 1)->get();
    foreach ($ids as $value) {
      $sdata = [
        "employee_id" => $value,
        "created_at" => $request->date
      ];
      $st = DB::table("attendances")->where($sdata)->first();

      if (!$st) {
        $sdata['status'] = $status[$value];
        DB::table("attendances")->insert($sdata);
      }
    }
    return redirect()->back()->with('msg', 'Attendance Inserted Successfully!!');
  }

  public function show(Request $request)
  {
    $data['title'] = "Attendance Report";
    $data['allEmp'] = DB::table("employees")->where("status", 1)->get();
    $search = $request->input("search");
    if ($search) {
      $empid = $request->input("empid");
      $sdate = $request->input("start_date");
      $edate = $request->input("end_date");
      $query = DB::table("attendances as ad")
        ->select("ad.id", "ad.status",  "ad.overtime", "ad.created_at", "em.name")
        ->join("employees as em", "em.id", "=", "ad.employee_id");
      if ($empid > 0) {
        $query->where("em.id", "=", $empid);
      }
      if ($sdate && $edate) {
        $query->where("ad.created_at", ">=", $sdate);
        $query->where("ad.created_at", "<=", $edate);
      } else if ($sdate) {
        $query->where("ad.created_at", $sdate);
      } else if ($edate) {
        $query->where("ad.created_at", $edate);
      }
      $data['results'] = $query->get();
    }
    return view('admincontrol.attendance.show', $data);
  }

  public function edit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['selected'] = DB::table("attendances")->find($id);
    $data['allEmp'] = DB::table("employees")->where("status", 1)->get();
    return view('admincontrol.attendance.edit', $data);
  }

  public function update(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data = [
      "status" => $request->status,
      "created_at" => $request->date
    ];
    $update = DB::table('attendances')
      ->where('id', '=', "$id")
      ->update($data);
    return redirect()->route('attendance.view')->with("msg", "Update successfully");
  }

  public function delete(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("attendances")->where("id", $id)->delete();
    return redirect()->back()->with("msg", "Attendance delete successfully");
  }

  public function overtime(Request $request)
  {
    $data['title'] = "Insert Overtime";
    $data['allEmp'] = DB::table("employees")->where("status", 1)->get();
    return view('admincontrol.attendance.overtime', $data);
  }

  public function overtimeStore(Request $request)
  {
    $ids = $request->input("ids");
    foreach ($ids as $value) {
      $sdata = [
        "employee_id" => $value,
        "created_at" => $request->date,
      ];
      $st = DB::table("attendances")->where($sdata)->first();
      $field = "ot-" . $value;
      if (!$st && $request->$field) {
        $sdata['status'] = 1;
        $sdata['overtime'] = $request->input('type');
        DB::table("attendances")->insert($sdata);
      }
    }
    return redirect()->back()->with('msg', 'Attendance Inserted Successfully!!');
  }

  public function overtimeEdit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['title'] = "Edit Overtime";
    $data['selected'] = DB::table("attendances")->find($id);
    $data['allEmp'] = DB::table("employees")->where("status", 1)->get();
    return view('admincontrol.attendance.overtimeEdit', $data);
  }
  public function overtimeUpdate(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data = [
      "employee_id" => $request->employee_id,
      "created_at" => $request->date,
      "overtime" => $request->type
    ];
    $update = DB::table('attendances')
      ->where('id', '=', "$id")
      ->update($data);
    return redirect()->route('attendance.view')->with("msg", "Update successfully");
  }
}
