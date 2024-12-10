<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AddproductController extends Controller
{
  public function index()
  {
    echo Auth::user()->id;
    //die();

    $data['product'] = DB::table('products')
      ->select('*')
      ->orderBy("title", "ASC")
      ->get();

    $data['bank'] = DB::table('banks')
      ->select('*')
      ->where("id", ">", 1)
      ->get();

    $data['customers'] = DB::table('customers')
      ->select('*')
      ->get();

    $data['custoname'] = DB::table('addproducts')
      ->join('customers', 'addproducts.customerid', '=', 'customers.id')
      ->select('addproducts.*', 'customers.company_name')
      ->get();
    $data['title'] = "Insert Addi.Product";
    return view('addproducts.new', $data);
  }

  public function create(Request $request)
  {
    $validationRules =
      [
        'sku' => 'required|max:200|unique:addproducts',
        'stock' => 'required',
        'date' => 'required',
      ];

    $customMessage = [
      'sku.required' => 'SKU is required.',
      'stock.required' => 'Stock is required.',
      'date.required' => 'Created Date is required.',
    ];

    $tableData = [
      'sku' => $request->input('sku'),
      'userid' => Auth::user()->id,
      'productid' => $request->input('product'),
      'customerid' => $request->input('customername'),
      'stock' => $request->input('stock'),
      'amount' => ($request->input('amount') / $request->input('stock')),
      'created_at' => $request->input('date'),
      'verified' => 1,
    ];

    //print_r($tableData);

    if ($request->input('payment_method') == 1) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';
      $tableData['cash'] = $request->input('amount');
    } else if ($request->input('payment_method') == 2) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';
      $tableData['due'] = $request->input('amount');
    } else if ($request->input('payment_method') == 3) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';
      $validationRules['only_cheque_bank_name'] = 'required|numeric';
      $customMessage['only_cheque_bank_name.required'] = 'Bank Name field must be fill';

      $tableData['bank_id'] = $request->input('only_cheque_bank_name');
      $tableData['bank_amount'] = $request->input('amount');
    } else if ($request->input('payment_method') == 4) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';
      $validationRules['cash_amount'] = 'required|numeric';
      $customMessage['cash_amount.required'] = 'Cash Amount  field must be fill';
      $validationRules['both_cheque_bank_name'] = 'required|numeric';
      $customMessage['both_cheque_bank_name.required'] = 'Bank Name field must be fill';
      $validationRules['both_cheque_amount'] = 'required|numeric';
      $customMessage['both_cheque_amount.required'] = 'Cheque Amount  field must be fill';
      $customMessage['both_cheque_amount.required|numeric'] = 'Cheque Amount  field must be fill';

      $tableData['cash'] = $request->input('cash_amount');
      $tableData['due'] = $request->input('due_amount');
      $tableData['bank_id'] = $request->input('both_cheque_bank_name');
      $tableData['bank_amount'] = $request->input('both_cheque_amount');
    }


    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $insert = DB::table('addproducts')
      ->insert($tableData);

    if (!$insert) {
      return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
    }
    return redirect()->back()->with('msg', 'Inserted Successfully!');;
  }

  public function show(Request $request)
  {
    $data['title'] = "Active Additional Product";
    $data['allPdt'] = DB::table('products')->orderBy("title", "asc")->get();
    $data['bank'] = DB::table('banks')
      ->select('*')
      ->where("id", ">", 1)
      ->get();

    $data['customers'] = DB::table('customers')
      ->select('*')
      ->orderBy("company_name", "asc")
      ->get();

    $search = $request->get("search");
    $pdtid = $request->get("pdtid");
    $customerid = $request->get("customerid");
    $paymethod_id = $request->get("paymethod_id");
    $sdate = $request->get("sdate");
    $edate = $request->get("edate");

    if ($search) {
      $rel = "";
      $query = DB::table('addproducts')
        ->join('customers', 'addproducts.customerid', '=', 'customers.id')
        ->join('products', 'addproducts.productid', '=', 'products.id')
        ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
        ->select(
          'addproducts.*',
          'customers.company_name',
          'products.title',
          'banks.name',
          DB::raw("(select sum(damages.quantity) from damages where damages.addproductid = addproducts.id) as totalDamages"),
          DB::raw('(select sum(addproducts_partial_payments.cash) from addproducts_partial_payments where addproducts_partial_payments.addproductid = addproducts.id) as installCash'),
          DB::raw('(select sum(addproducts_partial_payments.cheque) from addproducts_partial_payments where addproducts_partial_payments.addproductid = addproducts.id) as installCheque')
        )
        ->where("addproducts.status", 1);
      if ($pdtid) {
        $query->where("products.id", $pdtid);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "products.id='" . $pdtid . "'";
      }
      if ($customerid) {
        $query->where("customers.id", $customerid);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "customers.id='" . $customerid . "'";
      }
      if ($paymethod_id) {
        if ($paymethod_id == 1) {
          $query->where("addproducts.cash", ">", 0);
          if ($rel) {
            $rel .= " and ";
          }
          $rel .= "addproducts.cash > 0";
        } else if ($paymethod_id == 2) {
          $query->where("addproducts.due", ">", 0);
          if ($rel) {
            $rel .= " and ";
          }
          $rel .= "addproducts.due > 0";
        } else if ($paymethod_id == 3) {
          $query->where("addproducts.bank_amount", ">", 0);
          if ($rel) {
            $rel .= " and ";
          }
          $rel .= "addproducts.amount > 0";
        }
      }

      if ($sdate && $edate) {
        $query->where("addproducts.created_at", ">=", $sdate);
        $query->where("addproducts.created_at", "<=", $edate);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "addproducts.created_at >= '" . $sdate . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "addproducts.created_at <= '" . $edate . "'";
      } else if ($sdate) {
        $query->where("addproducts.created_at", $sdate);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "addproducts.created_at >= '" . $sdate . "'";
      } else if ($sdate) {
        $query->where("addproducts.created_at", $edate);
        $rel .= "addproducts.created_at >= '" . $sdate . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "addproducts.created_at <= '" . $edate . "'";
      }

      $data['newproduct'] = $query->orderBy("products.title", "ASC")
        ->orderBy("addproducts.id", "ASC")
        ->paginate(30);

      if ($rel) {
        $rel = " and " . $rel;
      } else {
        $rel = "";
      }

      $where = "addproducts, products, customers where addproducts.productid = products.id and addproducts.customerid = customers.id" . $rel;

      $data['totalAmount'] = DB::table('addproducts')
        ->select(
          DB::raw("(select sum(addproducts.amount * addproducts.stock) from $where) as total_amount"),
          DB::raw("(select sum(addproducts.cash) from $where) as total_cash"),
          DB::raw("(select sum(addproducts.due) from $where) as total_due"),
          DB::raw("(select sum(addproducts.bank_amount) from $where) as total_bank_amount")
        )
        ->first();

      $data['pdtid'] = $pdtid;
      $data['search'] = $request->get("search");
      $data['customerid'] = $request->get("customerid");
      $data['paymethod_id'] = $request->get("paymethod_id");
      $data['sdate'] = $request->get("sdate");
      $data['edate'] = $request->get("edate");
    } else {
      $data['newproduct'] = DB::table('addproducts')
        ->join('customers', 'addproducts.customerid', '=', 'customers.id')
        ->join('products', 'addproducts.productid', '=', 'products.id')
        ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
        ->select(
          'addproducts.*',
          'customers.company_name',
          'products.title',
          'banks.name',
          DB::raw("(select sum(damages.quantity) from damages where damages.addproductid = addproducts.id) as totalDamages"),
          DB::raw('(select sum(addproducts_partial_payments.cash) from addproducts_partial_payments where addproducts_partial_payments.addproductid = addproducts.id) as installCash'),
          DB::raw('(select sum(addproducts_partial_payments.cheque) from addproducts_partial_payments where addproducts_partial_payments.addproductid = addproducts.id) as installCheque')
        )
        ->where("addproducts.status", 1)
        ->orderBy("products.title", "ASC")
        ->orderBy("addproducts.id", "ASC")
        ->paginate(30);


      $where = "addproducts, products, customers where addproducts.productid = products.id and addproducts.customerid = customers.id";

      $data['totalAmount'] = DB::table('addproducts')
        ->select(
          DB::raw("(select sum(addproducts.amount * addproducts.stock) from $where) as total_amount"),
          DB::raw("(select sum(addproducts.cash) from $where) as total_cash"),
          DB::raw("(select sum(addproducts.due) from $where) as total_due"),
          DB::raw("(select sum(addproducts.bank_amount) from $where) as total_bank_amount")
        )
        ->first();

      $data['pdtid'] = 0;
    }
    return view('addproducts.view', $data);
  }

  public function frozen(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['title'] = "Active Additional Product";
    $data['allPdt'] = DB::table('products')->orderBy("title", "asc")->get();
    $data['customers'] = DB::table('customers')
      ->select('*')
      ->orderBy("company_name", "asc")
      ->get();

    $pdtid = $request->input("pdtid");
    if ($pdtid) {
      $data['newproduct'] = DB::table('addproducts')
        ->join('customers', 'addproducts.customerid', '=', 'customers.id')
        ->join('products', 'addproducts.productid', '=', 'products.id')
        ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
        ->select(
          'addproducts.*',
          'customers.company_name',
          'products.title',
          'banks.name'
        )
        ->where("addproducts.status", 0)
        ->where("products.id", $pdtid)
        ->orderBy("products.title", "ASC")
        ->orderBy("addproducts.id", "ASC")
        ->paginate(30);
      $data['pdtid'] = $pdtid;
    } else {
      $data['newproduct'] = DB::table('addproducts')
        ->join('customers', 'addproducts.customerid', '=', 'customers.id')
        ->join('products', 'addproducts.productid', '=', 'products.id')
        ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
        ->select(
          'addproducts.*',
          'customers.company_name',
          'products.title',
          'banks.name'
        )
        ->where("addproducts.status", 0)
        ->orderBy("products.title", "ASC")
        ->orderBy("addproducts.id", "ASC")
        ->paginate(30);
      $data['pdtid'] = 0;
    }
    return view('addproducts.view', $data);
  }

  public function edit($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['userid'] = $id;
    $data['bank'] = DB::table('banks')
      ->select('*')
      ->where("id", ">", 1)
      ->get();
    $data['custoname'] = DB::table('customers')
      ->select('*')
      ->get();
    $data['pdtname'] = DB::table('products')
      ->select('*')
      ->get();
    $data['product'] = DB::table('addproducts')
      ->where('id', "=", $id)
      ->first();
    $data['title'] = "Update Addi.Product";
    return view('addproducts.edit', $data);
  }

  public function update(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }

    $validationRules =
      [
        'sku' => 'required',
        'stock' => 'required',
        'date' => 'required',
      ];

    $customMessage = [
      'sku.required' => 'SKU is required.',
      'stock.required' => 'Stock is required.',
      'date.required' => 'Created Date is required.',
    ];

    $tableData = [
      'sku' => $request->input('sku'),

      'userid' => Auth::user()->id,
      'productid' => $request->get('product'),
      'customerid' => $request->get('customername'),
      'stock' => $request->input('stock'),
      'amount' => ($request->input('amount') / $request->input('stock')),
      'updated_at' => $request->input('date'),
      'verified' => 1,
      'status' => $request->input('status'),
    ];

    if ($request->input('payment_method') == 1) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';

      $tableData['cash'] = $request->input('amount');
      $tableData['due'] = 0;
      $tableData['bank_id'] = 0;
      $tableData['bank_amount'] = 0;
    } else if ($request->input('payment_method') == 2) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';

      $tableData['cash'] = 0;
      $tableData['due'] = $request->input('amount');
      $tableData['bank_id'] = 0;
      $tableData['bank_amount'] = 0;
    } else if ($request->input('payment_method') == 3) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';
      $validationRules['only_cheque_bank_name'] = 'required|numeric';
      $customMessage['only_cheque_bank_name.required'] = 'Bank Name field must be fill';

      $tableData['cash'] = 0;
      $tableData['due'] = 0;
      $tableData['bank_id'] = $request->input('only_cheque_bank_name');
      $tableData['bank_amount'] = $request->input('amount');
    } else if ($request->input('payment_method') == 4) {
      $validationRules['payment_method'] = 'required|numeric';
      $customMessage['payment_method.required'] = 'Payment Method field must be fill';
      $validationRules['amount'] = 'required|numeric';
      $customMessage['amount.required'] = 'Amount field must be fill';
      $validationRules['cash_amount'] = 'required|numeric';
      $customMessage['cash_amount.required'] = 'Cash Amount  field must be fill';
      $validationRules['both_cheque_bank_name'] = 'required|numeric';
      $customMessage['both_cheque_bank_name.required'] = 'Bank Name field must be fill';
      $validationRules['both_cheque_amount'] = 'required|numeric';
      $customMessage['both_cheque_amount.required'] = 'Cheque Amount  field must be fill';
      $customMessage['both_cheque_amount.required|numeric'] = 'Cheque Amount  field must be fill';

      $tableData['cash'] = $request->input('cash_amount');
      $tableData['due'] = $request->input('due_amount');
      $tableData['bank_id'] = $request->input('both_cheque_bank_name');
      $tableData['bank_amount'] = $request->input('both_cheque_amount');
    }

    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $update = DB::table('addproducts')
      ->where('id', $id)
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Information Not Updated!!');
    }
    return redirect()->back()->with('msg', 'Information is Updated Successfully!!!');
  }
  public function delete($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $delete[] = DB::table('addproducts')
      ->where("id", "=", "$id")
      ->delete();

    if (!$delete) {
      return redirect()->back()->with('error', 'Not Deleted!!');
    }
    return redirect()->route('addproduct.view')->with('msg', 'Deleted Successfully!');
  }


  public function status(Request $request, $id)
  {
    $data['bank'] = DB::table('banks')
      ->select('*')
      ->where("id", ">", 1)
      ->get();

    $data['product'] = DB::table('addproducts')
      ->join('customers', 'addproducts.customerid', '=', 'customers.id')
      ->join('products', 'addproducts.productid', '=', 'products.id')
      ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
      ->select(
        'addproducts.*',
        'customers.company_name',
        'products.title',
        'banks.name',
        DB::raw('(select sum(sales_details.quantity1) from sales_details where addproducts.id = sales_details.addproductsid and sales_details.quantity2 = 0) as totalSales1'),
        DB::raw('(select sum(sales_details.quantity2) from sales_details where addproducts.id = sales_details.addproductsid) as totalSales2')
      )
      ->where("addproducts.id", $id)->first();

    $data['partial'] = DB::table('addproducts_partial_payments')
      ->select('addproducts_partial_payments.*', 'banks.name')
      ->leftJoin('banks', 'addproducts_partial_payments.bank_id', '=', 'banks.id')
      ->where("addproducts_partial_payments.addproductid", $id)
      ->orderBy("addproducts_partial_payments.date", "asc")
      ->get();

    return view('addproducts.partial-new', $data);
  }

  public function status_store(Request $request, $id)
  {
    if ($request->input('payment_method') == 1) {
      $tableData['cash'] = $request->input('amount');
      $tableData['cheque'] = 0;
    } else if ($request->input('payment_method') == 2) {
      $tableData['bank_id'] = $request->input('only_cheque_bank_name');
      $tableData['cash'] = 0;
      $tableData['cheque'] = $request->input('amount');
    } else if ($request->input('payment_method') == 3) {
      $tableData['cash'] = $request->input('cash_amount');
      $tableData['bank_id'] = $request->input('both_cheque_bank_name');
      $tableData['cheque'] = $request->input('both_cheque_amount');
    }
    $tableData['addproductid'] = $id;
    $tableData['date'] = $request->input("date");
    $tableData['created_at'] = date("Y-m-d H:i:s");

    //
    // print_r($tableData);
    // die();
    $product = DB::table('addproducts')->find($id);
    $due = $product->due - ($tableData['cash'] + $tableData['cheque']);

    $insert = DB::table('addproducts_partial_payments')
      ->insert($tableData);

    if (!$insert) {
      return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
    }


    DB::table('addproducts')->where("id", $id)->update(['due' => $due]);
    return redirect()->back()->with('msg', 'Inserted Successfully!');
  }

  public function status_delete(Request $request, $id)
  {
    $install = DB::table('addproducts_partial_payments')->find($id);
    DB::table("addproducts_partial_payments")->where("id", $id)->delete();

    $product = DB::table('addproducts')->find($install->addproductid);
    $due = $product->due + $install->cash + $install->cheque;

    DB::table('addproducts')->where("id", $product->id)->update(['due' => $due]);
    return redirect()->back()->with('msg', 'Delete Successfully!');;
  }
}
