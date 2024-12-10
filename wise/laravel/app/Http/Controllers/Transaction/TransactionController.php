<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\OurPayment;


class TransactionController extends Controller
{
  public function new_deposit(Request $request)
  {
    $data['title'] = "Deposit";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $search = $request->get('search');
    if ($search) {
      $bankid = $request->get('bankid');
      $description = $request->get('description');
      $sdate = $request->get('sdate');
      $edate = $request->get('edate');

      $data['bf'] = 0;
      if ($sdate || $edate) {
        $query = DB::table('transaction')
          ->select(DB::raw("SUM(amount) as amount"))
          ->where("type", "=", 1);

        if ($bankid >= 0) {
          $query->where("bankid", $bankid);
        }
        if ($sdate) {
          $query->where("date", "<", $sdate);
        } else if ($edate) {
          $query->where("date", "<", $edate);
        }
        $query->where("date", ">=", '2024-07-05');
        $total  = $query->first();
        $data['bf'] =  $total->amount;
      }

      $rel = " where type = 1";

      $query = DB::table('transaction')
        ->where("type", "=", 1);

      if ($bankid >= 0) {
        $query->where("bankid", $bankid);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "bankid='" . $bankid . "'";
      }
      if ($description != "") {
        $query->where("description", "like", $description);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "description like '%" . $description . "%'";
      }

      if ($sdate && $edate) {
        $query->where("date", ">=", $sdate);
        $query->where("date", "<=", $edate);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date >= '" . $sdate . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date <= '" . $edate . "'";
      } else if ($sdate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date = '" . $sdate . "'";
        $query->where("date", $sdate);
      } else if ($edate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date='" . $sdate . "'";
        $query->where("date", $edate);
      }
      $query->where('date', '>=', '2024-07-05');
      $rel .= " and date >= '2024-07-05'";

      $query->orderBy("date", "desc");
      $data['transaction']  = $query->paginate();
      $net = DB::table('addproducts')->select(DB::raw("(select sum(amount) from transaction $rel) as total_amount"))->first();
      $data['net'] = $net->total_amount;

      $data['url_var'] = [
        "bankid" => $request->input("bankid"),
        "description" => $request->input("description"),
        "sdate" => $request->input("sdate"),
        "edate" => $request->input("edate"),
        "search" => $request->input("search")
      ];
    } else {
      $data['bf'] = 0;
      $query = DB::table('transaction')
        ->select(DB::raw("SUM(amount) as amount"))
        ->where("type", "=", 1)
        ->where('date', '>=', '2024-07-05');

      $total  = $query->where("date", "<=", date("Y-m-d"))->first();
      $data['bf'] = 0;
      $data['net'] = $total->amount;
      $data['url_var'] = [];

      $data['transaction'] = DB::table('transaction')
        ->where("type", "=", 1)
        ->where('date', '>=', '2024-07-05')
        ->orderBy("date", "desc")
        ->paginate();
    }

    return view('admincontrol.transaction.transaction-deposit')->with($data);
  }
  public function store_new_deposit(Request $request)
  {
    $sdata = [
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 1,
      "method" => $request->input("method")
    ];
    DB::table("transaction")->insert($sdata);
    return redirect()->back()->with("msg", "Save Successfully");
  }
  public function edit_deposit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['selected'] = DB::table('transaction')
      ->where("type", "=", 1)
      ->where("id", "=", $id)
      ->where("salesid", "=", 0)
      ->orderBy("id", "desc")
      ->get();

    if (!count($data['selected'])) {
      return redirect()->route('transaction.new-deposit')->with("error", "Some error occurs");
    }

    $data['title'] = "Deposit";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];


    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    return view('admincontrol.transaction.transaction-deposit-edit')->with($data);
  }
  public function update_new_deposit(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $sdata = [
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 1,
      "method" => $request->input("method")
    ];
    DB::table("transaction")
      ->where("salesid", 0)
      ->where("id", $request->input('id'))
      ->update($sdata);
    return redirect()->route('transaction.new-deposit')->with("msg", "Update Successfully");
  }

  public function delete_deposit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("transaction")
      ->where("id", $id)
      ->where("type", 1)
      ->where("salesid", 0)
      ->delete();
    return redirect()->route('transaction.new-deposit')->with("msg", "Delete Successfully");
  }




  public function new_expense(Request $request)
  {
    $data['title'] = "Expense";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];
    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $search = $request->get('search');
    if ($search) {
      $bankid = $request->get('bankid');
      $description = $request->get('description');
      $sdate = $request->get('sdate');
      $edate = $request->get('edate');

      $data['bf'] = 0;
      if ($sdate || $edate) {
        $query = DB::table('transaction')
          ->select(DB::raw("SUM(amount) as amount"))
          ->where("type", "=", 2);

        if ($bankid >= 0) {
          $query->where("bankid", $bankid);
        }
        if ($sdate) {
          $query->where("date", "<", $sdate);
        } else if ($edate) {
          $query->where("date", "<", $edate);
        }
        $query->where("date", ">=", '2024-07-05');
        $total  = $query->first();
        $data['bf'] =  $total->amount;
      }

      $rel = " where type = 2";
      $query = DB::table('transaction')
        ->where("type", "=", 2);

      if ($bankid >= 0) {
        $query->where("bankid", $bankid);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "bankid='" . $bankid . "'";
      }
      if ($description != "") {
        $query->where("description", "like", $description);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "description like '%" . $description . "%'";
      }
      if ($sdate && $edate) {
        $query->where("date", ">=", $sdate);
        $query->where("date", "<=", $edate);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date >= '" . $sdate . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date <= '" . $edate . "'";
      } else if ($sdate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date = '" . $sdate . "'";
        $query->where("date", $sdate);
      } else if ($edate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "date='" . $sdate . "'";
        $query->where("date", $edate);
      }
      $query->where('date', '>=', '2024-07-05');
      $rel .= " and date >= '2024-07-05'";

      $query->orderBy("date", "desc");
      $data['transaction']  = $query->paginate();
      $net = DB::table('addproducts')->select(DB::raw("(select sum(amount) from transaction $rel) as total_amount"))->first();
      $data['net'] = $net->total_amount;

      $data['url_var'] = [
        "bankid" => $request->input("bankid"),
        "description" => $request->input("description"),
        "sdate" => $request->input("sdate"),
        "edate" => $request->input("edate"),
        "search" => $request->input("search")
      ];
    } else {
      $data['bf'] = 0;
      $query = DB::table('transaction')
        ->select(DB::raw("SUM(amount) as amount"))
        ->where("type", "=", 2)
        ->where('date', '>=', '2024-07-05');

      $total  = $query->where("date", "<=", date("Y-m-d"))->first();
      $data['bf'] = 0;
      $data['net'] = $total->amount;
      $data['url_var'] = [];

      $data['transaction'] = DB::table('transaction')
        ->where("type", "=", 2)
        ->where('date', '>=', '2024-07-05')
        ->orderBy("date", "desc")
        ->paginate();
    }

    return view('admincontrol.transaction.transaction-expense')->with($data);
  }
  public function store_new_expense(Request $request)
  {
    $sdata = [
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 2,
      "method" => $request->input("method")
    ];
    DB::table("transaction")->insert($sdata);
    return redirect()->back()->with("msg", "Save Successfully");
  }
  public function edit_expense(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['selected'] = DB::table('transaction')
      ->where("type", "=", 2)
      ->where("id", "=", $id)
      ->where("salesid", "=", 0)
      ->orderBy("id", "desc")
      ->get();

    if (!count($data['selected'])) {
      return redirect()->route('transaction.new-expense')->with("error", "Some error occurs");
    }

    $data['title'] = "Expense";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];


    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    return view('admincontrol.transaction.transaction-expense-edit')->with($data);
  }
  public function update_new_expense(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $sdata = [
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 2,
      "method" => $request->input("method")
    ];
    DB::table("transaction")
      ->where("salesid", 0)
      ->where("id", $request->input('id'))
      ->update($sdata);
    return redirect()->route('transaction.new-expense')->with("msg", "Update Successfully");
  }

  public function delete_expense(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("transaction")
      ->where("id", $id)
      ->where("type", 2)
      ->where("salesid", 0)
      ->delete();
    return redirect()->route('transaction.new-expense')->with("msg", "Delete Successfully");
  }



  public function new_transfer(Request $request)
  {
    $data['title'] = "Expense";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];
    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $search = $request->get('search');
    if ($search) {
      $bankid = $request->get('bankid');
      $sdate = $request->get('sdate');
      $edate = $request->get('edate');

      $data['bf'] = 0;
      if ($sdate || $edate) {
        $query = DB::table('transaction')
          ->select(DB::raw("SUM(amount) as amount"))
          ->where("type", "=", 3);

        if ($bankid >= 0) {
          $query->where("bankid", $bankid);
        }
        if ($sdate) {
          $query->where("date", "<", $sdate);
        } else if ($edate) {
          $query->where("date", "<", $edate);
        }
        $query->where("date", ">=", '2024-07-05');
        $total  = $query->first();
        $data['bf'] =  $total->amount;
      }

      $query = DB::table('transaction')
        ->select("transaction.*", "bk1.name as from_name", "bk2.name as to_name")
        ->join("banks as bk1", "bk1.id", "=", "transaction.bankid")
        ->join("banks as bk2", "bk2.id", "=", "transaction.method")
        ->where("transaction.type", "=", 3);

      if ($bankid >= 0) {
        $query->where("transaction.bankid", $bankid);
      }
      if ($sdate && $edate) {
        $query->where("transaction.date", ">=", $sdate);
        $query->where("transaction.date", "<=", $edate);
      } else if ($sdate) {
        $query->where("transaction.date", $sdate);
      } else if ($edate) {
        $query->where("transaction.date", $edate);
      }
      $query->where('date', '>=', '2024-07-05');

      $query->orderBy("transaction.date", "desc");
      $data['transaction']  = $query->paginate();
    } else {
      $data['transaction'] = DB::table('transaction')
        ->select("transaction.*", "bk1.name as from_name", "bk2.name as to_name")
        ->join("banks as bk1", "bk1.id", "=", "transaction.bankid")
        ->join("banks as bk2", "bk2.id", "=", "transaction.method")
        ->where("transaction.type", "=", 3)
        ->where('date', '>=', '2024-07-05')
        ->orderBy("transaction.date", "desc")
        ->paginate();
    }

    return view('admincontrol.transaction.transfer')->with($data);
  }
  public function store_new_transfer(Request $request)
  {
    $sdata = [
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 3,
      "method" => $request->input("method")
    ];
    DB::table("transaction")->insert($sdata);
    return redirect()->back()->with("msg", "Save Successfully");
  }
  public function edit_transfer(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['selected'] = DB::table('transaction')
      ->where("type", "=", 3)
      ->where("id", "=", $id)
      ->where("salesid", "=", 0)
      ->orderBy("id", "desc")
      ->get();

    if (!count($data['selected'])) {
      return redirect()->route('transaction.transfer')->with("error", "Some error occurs");
    }

    $data['title'] = "Expense";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    return view('admincontrol.transaction.transfer-edit')->with($data);
  }
  public function update_new_transfer(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $sdata = [
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 3,
      "method" => $request->input("method")
    ];
    DB::table("transaction")
      ->where("salesid", 0)
      ->where("id", $request->input('id'))
      ->update($sdata);
    return redirect()->route('transaction.transfer')->with("msg", "Update Successfully");
  }

  public function delete_transfer(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("transaction")
      ->where("id", $id)
      ->where("type", 3)
      ->where("salesid", 0)
      ->delete();
    return redirect()->route('transaction.transfer')->with("msg", "Delete Successfully");
  }



  public function balancesheet(Request $request)
  {
    $sdate = $request->input("sdate");
    $edate = $request->input("edate");
    if ($sdate && $edate) {
      $data['income'] = DB::table('transaction')
        ->select("bankid", "date", DB::raw("SUM(amount) as eamount"))
        ->where("type", "=", 1)
        ->where("date", ">=", $sdate)
        ->where("date", "<=", $edate)
        ->first();

      $data['expense'] = DB::table('transaction')
        ->select("bankid", "date", DB::raw("SUM(amount) as eamount"))
        ->where("type", "=", 2)
        ->where("date", ">=", $sdate)
        ->where("date", "<=", $edate)
        ->first();
    }

    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $data['deposits'] = DB::table('transaction')
      ->select("bankid", DB::raw("SUM(amount) as tamount"))
      ->where("type", "=", 1)
      ->groupBy("bankid")
      ->get();

    $data['expenses'] = DB::table('transaction')
      ->select("bankid", DB::raw("SUM(amount) as tamount"))
      ->where("type", "=", 2)
      ->groupBy("bankid")
      ->get();

    $data['transfers_in'] = DB::table('transaction')
      ->select("bankid", "method", DB::raw("SUM(amount) as tamount"))
      ->where("type", "=", 3)
      ->groupBy("method", "bankid")
      ->get();

    $data['transfers_out'] = DB::table('transaction')
      ->select("bankid", "method", DB::raw("SUM(amount) as tamount"))
      ->where("type", "=", 3)
      ->groupBy("bankid", "method")
      ->get();

    return view('admincontrol.transaction.balancesheet')->with($data);
  }

  public function employee_credit(Request $request)
  {
    $data['title'] = "Deposit";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    $data['employee'] = DB::table('employees')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $search = $request->get('search');
    if ($search) {
      $employee_id = $request->get('employee_id');
      $bankid = $request->get('bankid');
      $description = $request->get('description');
      $sdate = $request->get('sdate');
      $edate = $request->get('edate');

      $data['bf'] = 0;
      if ($sdate || $edate) {
        $query = DB::table('transaction')
          ->select(DB::raw("SUM(transaction.amount) as amount"))
          ->where("type", "=", 4);

        if ($bankid >= 0) {
          $query->where("transaction.bankid", $bankid);
        }
        if ($sdate) {
          $query->where("transaction.date", "<", $sdate);
        } else if ($edate) {
          $query->where("transaction.date", "<", $edate);
        }
        $total  = $query->first();
        $data['bf'] =  $total->amount;
      }

      $rel = " where transaction.type = 4";
      $query = DB::table('transaction')
        ->where("type", "=", 4);

      if ($employee_id >= 0) {
        $query->where("transaction.employee_id", $employee_id);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.employee_id='" . $employee_id . "'";
      }

      if ($bankid >= 0) {
        $query->where("transaction.bankid", $bankid);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.bankid='" . $bankid . "'";
      }
      if ($description != "") {
        $query->where("transaction.description", "like", $description);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.description like '%" . $description . "%'";
      }

      if ($sdate && $edate) {
        $query->where("transaction.date", ">=", $sdate);
        $query->where("transaction.date", "<=", $edate);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date >= '" . $sdate . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date <= '" . $edate . "'";
      } else if ($sdate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date = '" . $sdate . "'";
        $query->where("transaction.date", $sdate);
      } else if ($edate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date='" . $sdate . "'";
        $query->where("transaction.date", $edate);
      }
      $query->join('employees', 'employees.id', '=', 'transaction.employee_id');
      $query->select('transaction.id', 'employees.name', 'transaction.date', 'transaction.description', 'transaction.amount', 'transaction.invoice_start', 'transaction.invoice_end');

      $query->orderBy("date", "desc");
      $data['transaction']  = $query->paginate();
      $net = DB::table('addproducts')->select(DB::raw("(select sum(amount) from transaction $rel) as total_amount"))->first();
      $data['net'] = $net->total_amount;

      $data['url_var'] = [
        "bankid" => $request->input("bankid"),
        "description" => $request->input("description"),
        "sdate" => $request->input("sdate"),
        "edate" => $request->input("edate"),
        "search" => $request->input("search")
      ];
    } else {
      $data['bf'] = 0;
      $query = DB::table('transaction')
        ->select(DB::raw("SUM(amount) as amount"))
        ->where("type", "=", 4);

      $total  = $query->where("date", "<=", date("Y-m-d"))->first();
      $data['bf'] = 0;
      $data['net'] = $total->amount;
      $data['url_var'] = [];

      $data['transaction'] = DB::table('transaction')
        ->select('transaction.id', 'employees.name', 'transaction.date', 'transaction.description', 'transaction.amount', 'transaction.invoice_start', 'transaction.invoice_end')
        ->join('employees', 'employees.id', '=', 'transaction.employee_id')
        ->where("type", "=", 4)
        ->orderBy("date", "desc")
        ->paginate();
    }

    return view('admincontrol.transaction.employee-credit')->with($data);
  }

  public function store_employee_credit(Request $request)
  {
    $sdata = [
      "employee_id" => $request->input('employee_id'),
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 4,
      "method" => $request->input("method")
    ];
    DB::table("transaction")->insert($sdata);
    return redirect()->back()->with("msg", "Save Successfully");
  }

  public function edit_employee_credit(Request $request, $id)
  {
    $data['employee'] = DB::table('employees')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['selected'] = DB::table('transaction')
      ->where("type", "=", 4)
      ->where("id", "=", $id)
      ->where("salesid", "=", 0)
      ->orderBy("id", "desc")
      ->get();

    if (!count($data['selected'])) {
      return redirect()->route('transaction.employee-credit')->with("error", "Some error occurs");
    }

    $data['title'] = "Deposit";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];


    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    return view('admincontrol.transaction.employee-credit-edit')->with($data);
  }

  public function update_employee_credit(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $sdata = [
      "employee_id" => $request->input('employee_id'),
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 4,
      "method" => $request->input("method")
    ];
    DB::table("transaction")
      ->where("salesid", 0)
      ->where("id", $request->input('id'))
      ->update($sdata);
    return redirect()->route('transaction.employee-credit')->with("msg", "Update Successfully");
  }

  public function delete_employee_credit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("transaction")
      ->where("id", $id)
      ->where("type", 4)
      ->where("salesid", 0)
      ->delete();
    return redirect()->back()->with("msg", "Delete Successfully");
  }

  public function employee_debit(Request $request)
  {
    $data['title'] = "Deposit";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    $data['employee'] = DB::table('employees')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $search = $request->get('search');
    if ($search) {
      $employee_id = $request->get('employee_id');
      $bankid = $request->get('bankid');
      $description = $request->get('description');
      $sdate = $request->get('sdate');
      $edate = $request->get('edate');

      $data['bf'] = 0;
      if ($sdate || $edate) {
        $query = DB::table('transaction')
          ->select(DB::raw("SUM(transaction.amount) as amount"))
          ->where("type", "=", 5);

        if ($bankid >= 0) {
          $query->where("transaction.bankid", $bankid);
        }
        if ($sdate) {
          $query->where("transaction.date", "<", $sdate);
        } else if ($edate) {
          $query->where("transaction.date", "<", $edate);
        }
        $total  = $query->first();
        $data['bf'] =  $total->amount;
      }

      $rel = " where transaction.type = 5";
      $query = DB::table('transaction')
        ->where("type", "=", 5);

      if ($employee_id >= 0) {
        $query->where("transaction.employee_id", $employee_id);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.employee_id='" . $employee_id . "'";
      }

      if ($bankid >= 0) {
        $query->where("transaction.bankid", $bankid);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.bankid='" . $bankid . "'";
      }
      if ($description != "") {
        $query->where("transaction.description", "like", $description);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.description like '%" . $description . "%'";
      }

      if ($sdate && $edate) {
        $query->where("transaction.date", ">=", $sdate);
        $query->where("transaction.date", "<=", $edate);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date >= '" . $sdate . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date <= '" . $edate . "'";
      } else if ($sdate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date = '" . $sdate . "'";
        $query->where("transaction.date", $sdate);
      } else if ($edate) {
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "transaction.date='" . $sdate . "'";
        $query->where("transaction.date", $edate);
      }
      $query->join('employees', 'employees.id', '=', 'transaction.employee_id');
      $query->select('transaction.id', 'employees.name', 'transaction.date', 'transaction.description', 'transaction.amount', 'transaction.invoice_start', 'transaction.invoice_end');

      $query->orderBy("date", "desc");
      $data['transaction']  = $query->paginate();
      $net = DB::table('addproducts')->select(DB::raw("(select sum(amount) from transaction $rel) as total_amount"))->first();
      $data['net'] = $net->total_amount;

      $data['url_var'] = [
        "bankid" => $request->input("bankid"),
        "description" => $request->input("description"),
        "sdate" => $request->input("sdate"),
        "edate" => $request->input("edate"),
        "search" => $request->input("search")
      ];
    } else {
      $data['bf'] = 0;
      $query = DB::table('transaction')
        ->select(DB::raw("SUM(amount) as amount"))
        ->where("type", "=", 5);

      $total  = $query->where("date", "<=", date("Y-m-d"))->first();
      $data['bf'] = 0;
      $data['net'] = $total->amount;
      $data['url_var'] = [];

      $data['transaction'] = DB::table('transaction')
        ->select('transaction.id', 'employees.name', 'transaction.date', 'transaction.description', 'transaction.amount', 'transaction.invoice_start', 'transaction.invoice_end')
        ->join('employees', 'employees.id', '=', 'transaction.employee_id')
        ->where("type", "=", 5)
        ->orderBy("date", "desc")
        ->paginate();
    }

    return view('admincontrol.transaction.employee-debit')->with($data);
  }

  public function store_employee_debit(Request $request)
  {
    $sdata = [
      "employee_id" => $request->input('employee_id'),
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 5,
      "method" => $request->input("method")
    ];
    DB::table("transaction")->insert($sdata);
    return redirect()->back()->with("msg", "Save Successfully");
  }

  public function edit_employee_debit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['employee'] = DB::table('employees')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    $data['selected'] = DB::table('transaction')
      ->where("type", "=", 5)
      ->where("id", "=", $id)
      ->where("salesid", "=", 0)
      ->orderBy("id", "desc")
      ->get();

    if (!count($data['selected'])) {
      return redirect()->route('transaction.employee-debit')->with("error", "Some error occurs");
    }

    $data['title'] = "Deposit";
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];


    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    return view('admincontrol.transaction.employee-debit-edit')->with($data);
  }

  public function update_employee_debit(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $sdata = [
      "employee_id" => $request->input('employee_id'),
      "bankid" => $request->input('bankid'),
      "date" => $request->input('date'),
      "description" => $request->input('description'),
      "amount" => $request->input('amount'),
      "type" => 5,
      "method" => $request->input("method")
    ];
    DB::table("transaction")
      ->where("salesid", 0)
      ->where("id", $request->input('id'))
      ->update($sdata);
    return redirect()->route('transaction.employee-debit')->with("msg", "Update Successfully");
  }

  public function delete_employee_debit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("transaction")
      ->where("id", $id)
      ->where("type", 5)
      ->where("salesid", 0)
      ->delete();
    return redirect()->back()->with("msg", "Delete Successfully");
  }

  public function employee_balance_sheet()
  {
    $data['title'] = "Employee Balance Sheet";
    $data['employee'] = DB::table('employees')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $data['creditTransaction'] = DB::table('transaction')
      ->select("employee_id", DB::raw("SUM(amount) as total"))
      ->where("type", "=", 4)
      ->where("employee_id", ">", 0)
      ->groupBy("employee_id")
      ->get();

    $data['debitTransaction'] = DB::table('transaction')
      ->select("employee_id", DB::raw("SUM(amount) as total"))
      ->where("type", "=", 5)
      ->where("employee_id", ">", 0)
      ->groupBy("employee_id")
      ->get();

    $data['salaryReturn'] = DB::table('salary')
      ->select('employeeid', DB::raw("SUM(credit_adjust) as totalPaid"))
      ->where('date', '>=', '2024-07-01')
      ->groupBy('employeeid')
      ->get();

    return view('admincontrol.transaction.employee-balance-sheet')->with($data);
  }

  public function employee_balance_sheet_details(Request $request, $id)
  {
    $data['title'] = "Employee Balance Sheet Details";
    $perPage = 10;
    $page = 1;
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    }

    $data['employee'] = DB::table('employees')
      ->where("status", "=", 1)
      ->where("id", "=", $id)
      ->first();

    $data['prevTotalCreditDebit'] = DB::table('transaction')
      ->select('type', 'amount')
      ->where("employee_id", "=", $id)
      ->take(($page - 1) * $perPage)
      ->orderBy("date", "desc")
      ->get();

    $data['prevTotalDebit'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as total"))
      ->where("type", "=", 5)
      ->where("employee_id", "=", $id)
      ->first();


    $data['transaction'] = DB::table('transaction')
      ->select("date", "amount", "type", 'description')
      ->where("employee_id", "=", $id)
      ->orderBy("date", "desc")
      ->paginate($perPage);

    $data['totalCredit'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as total"))
      ->where("type", "=", 4)
      ->where("employee_id", "=", $id)
      ->first();

    $data['totalDebit'] = DB::table('transaction')
      ->select(DB::raw("SUM(amount) as total"))
      ->where("type", "=", 5)
      ->where("employee_id", "=", $id)
      ->first();

    $data['salaryReturn'] = DB::table('salary')
      ->select(DB::raw("SUM(credit_adjust) as totalPaid"))
      ->where('date', '>=', '2024-07-01')
      ->where('employeeid', "=", $id)
      ->first();

    return view('admincontrol.transaction.employee-balance-sheet-details')->with($data);
  }
}
