<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index()
  {
    ##########  Balance Sheet Start ##################
    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $data['allDepositAmount'] = DB::table('transaction')
      ->select("bankid", DB::raw("SUM(amount) as damount"))
      ->where("type", "=", 1)
      ->where('date', '>=', '2024-07-05')
      ->groupBy("bankid")
      ->get();



    $data['allExpenseAmount'] = DB::table('transaction')
      ->select("bankid", DB::raw("SUM(amount) as eamount"))
      ->where("type", "=", 2)
      ->where('date', '>=', '2024-07-05')
      ->groupBy("bankid")
      ->get();

    $data['allEmployeeCredit'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as eCredit"))
      ->where("type", "=", 4)
      ->where('date', '>=', '2024-07-05')
      ->first();

    $data['allEmployeeDebit'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as eDebit"))
      ->where("type", "=", 5)
      ->where('date', '>=', '2024-07-05')
      ->first();

    // echo "<pre>";
    // print_r($data['allExpenseAmount']);
    // echo "</pre>";
    // die();

    $data['total_transfer'] = DB::table('transaction')
      ->select("bankid", "method", DB::raw("SUM(amount) as tamount"))
      ->where("type", "=", 3)
      ->where('date', '>=', '2024-07-05')
      ->groupBy("bankid", "method")
      ->get();


    $data['incomeToday'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as eamount"))
      ->where("type", "=", 1)
      ->where("date", date("Y-m-d"))
      ->first();

    $data['expenseToday'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as eamount"))
      ->where("type", "=", 2)
      ->where("date", date("Y-m-d"))
      ->first();

    $data['incomeThisMonth'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as eamount"))
      ->where("type", "=", 1)
      ->where("date", date("Y-m-d"))
      ->first();

    $data['expenseThisMonth'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as eamount"))
      ->where("type", "=", 2)
      ->where("date", "like", date("Y-m") . "%")
      ->first();





    ##########  Balance Sheet End ##################

    $data['invoiceSummary'] = DB::table('sales')
      ->select(
        DB::raw("(select count(id) from sales where status=0) as pending"),
        DB::raw("(select count(id) from sales where status=1) as paid")
      )
      ->first();

    $data['dueTomorrow'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.projectid", "=", 0)
      ->where("sales.status", 0)
      ->where("sales.due_date", "=", date("Y-m-d", strtotime("+1 day")))
      ->orderBy("sales.id", "desc")
      ->get();

    $data['dueThisWeeks'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.projectid", "=", 0)
      ->where("sales.due_date", ">=", date("Y-m-d"))
      ->where("sales.due_date", "<=", date("Y-m-d", strtotime("+7 day")))
      ->where("sales.status", 0)
      ->orderBy("sales.id", "desc")
      ->get();

    $data['overDue'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.projectid", "=", 0)
      ->where("sales.due_date", "<", date("Y-m-d"))
      ->where("sales.status", 0)
      ->orderBy("sales.id", "desc")
      ->paginate();

    $data['overDueAmount'] = DB::table('sales')
      ->select(DB::raw('SUM(sales.amount) as total_sales'))
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.projectid", "=", 0)
      ->where("sales.due_date", "<", date("Y-m-d"))
      ->where("sales.status", 0)
      ->first();



    return view("dashboard", $data);
  }
}
