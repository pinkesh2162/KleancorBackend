<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\OurPayment;
use PDF;

class InvoiceController extends Controller
{
  public function index(Request $request)
  {

    $data['title'] = "All Invoice";
    $data['customers'] = DB::table("customers")->orderBy("company_name")->get();

    $data['customerid'] = $request->input("customerid");
    $data['start_date'] = $request->input("start_date");
    $data['end_date'] = $request->input("end_date");
    $data['status'] = $request->input("status");
    $search = $request->input("search");

    if ($search) {
      $rel = "";
      $sql =  DB::table('sales')
        ->select(
          'sales.*',
          'customers.company_name',
          'customers.contact_person',
          DB::raw("(select sum(transaction.amount) from transaction where transaction.salesid=sales.id) as tr_amount"),
          DB::raw("(select sum(transaction.vat) from transaction where transaction.salesid=sales.id) as tr_vat"),
          DB::raw("(select sum(transaction.tax) from transaction where transaction.salesid=sales.id) as tr_tax")
        )
        ->join("customers", "customers.id", "=", "sales.customerid")
        ->where("sales.projectid", "=", 0);

      if ($data['customerid'] > 0) {
        $sql->where("customers.id", $data['customerid']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.customerid='" . $data['customerid'] . "'";
      }
      if ($data['status'] > -1) {
        $sql->where("sales.status", $data['status']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.status='" . $data['status'] . "'";
      }
      if ($data['start_date'] != "" && $data['end_date'] != "") {
        $sql->where("sales.created_at", ">=", $data['start_date']);
        $sql->where("sales.created_at", "<=", $data['end_date']);

        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at >= '" . $data['start_date'] . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at <= '" . $data['end_date'] . "'";
      } else if ($data['start_date'] != "") {
        $sql->where("sales.created_at", "=", $data['start_date']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at='" . $data['start_date'] . "'";
      } else if ($data['end_date'] != "") {
        $sql->where("sales.created_at", "=", $data['end_date']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at='" . $data['end_date'] . "'";
      }
      $data['allInvoice'] = $sql->orderBy("sales.created_at", "desc")->paginate(30);

      if ($rel) {
        $rel2 = " where " . $rel;
        $rel = " and " . $rel;
      } else {
        $rel2 = "";
      }



      $data['total'] = DB::table('sales')
        ->select(
          DB::raw("(select sum(sales.amount) from sales $rel2) as sales_amount"),
          DB::raw("(select sum((sales.amount*sales.tax)/100) from sales $rel2) as sales_tax"),
          DB::raw("(select sum(transaction.amount) from transaction, sales where sales.id = transaction.salesid $rel) as tran_amount"),
          DB::raw("(select sum(transaction.tax) from transaction, sales where sales.id = transaction.salesid $rel) as tran_tax"),
          DB::raw("(select sum(transaction.discount) from transaction, sales where sales.id = transaction.salesid $rel) as tran_discount")
        )
        ->first();
    } else {
      $data['total'] = DB::table('sales')
        ->select(
          DB::raw("(select sum(sales.amount) from sales) as sales_amount"),
          DB::raw("(select sum((sales.amount*sales.tax)/100) from sales) as sales_tax"),
          DB::raw("(select sum(transaction.amount) from transaction where salesid!=0) as tran_amount"),
          DB::raw("(select sum(transaction.tax) from transaction where salesid!=0) as tran_tax"),
          DB::raw("(select sum(transaction.discount) from transaction where salesid!=0) as tran_discount")
        )
        ->first();

      $data['allInvoice'] = DB::table('sales')
        ->select(
          'sales.*',
          'customers.company_name',
          'customers.contact_person',
          DB::raw("(select sum(transaction.amount) from transaction where transaction.salesid=sales.id) as tr_amount"),
          DB::raw("(select sum(transaction.vat) from transaction where transaction.salesid=sales.id) as tr_vat"),
          DB::raw("(select sum(transaction.tax) from transaction where transaction.salesid=sales.id) as tr_tax")
        )
        ->join("customers", "customers.id", "=", "sales.customerid")
        ->where("sales.projectid", "=", 0)
        ->orderBy("sales.created_at", "desc")
        ->paginate(30);
    }
    return view('admincontrol.invoice.invoice-all')->with($data);
  }

  public function partial(Request $request)
  {
    $data['title'] = "All Invoice";
    $data['customers'] = DB::table("customers")->orderBy("company_name")->get();

    $data['customerid'] = $request->input("customerid");
    $data['start_date'] = $request->input("start_date");
    $data['end_date'] = $request->input("end_date");
    $data['status'] = $request->input("status");
    $search = $request->input("search");

    if ($search) {
      $rel = "";
      $sql =  DB::table('sales')
        ->select('sales.*', 'customers.company_name', 'customers.contact_person')
        ->join("customers", "customers.id", "=", "sales.customerid")
        ->where("sales.projectid", "=", 0);

      if ($data['customerid'] > 0) {
        $sql->where("customers.id", $data['customerid']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.customerid='" . $data['customerid'] . "'";
      }
      if ($data['status'] > -1) {
        $sql->where("sales.status", $data['status']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.status='" . $data['status'] . "'";
      }
      if ($data['start_date'] != "" && $data['end_date'] != "") {
        $sql->where("sales.created_at", ">=", $data['start_date']);
        $sql->where("sales.created_at", "<=", $data['end_date']);

        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at >= '" . $data['start_date'] . "'";
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at <= '" . $data['end_date'] . "'";
      } else if ($data['start_date'] != "") {
        $sql->where("sales.created_at", "=", $data['start_date']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at='" . $data['start_date'] . "'";
      } else if ($data['end_date'] != "") {
        $sql->where("sales.created_at", "=", $data['end_date']);
        if ($rel) {
          $rel .= " and ";
        }
        $rel .= "sales.created_at='" . $data['end_date'] . "'";
      }
      $data['allInvoice'] = $sql->orderBy("sales.id", "desc")->get();

      if ($rel) {
        $rel2 = " where " . $rel;
        $rel = " and " . $rel;
      } else {
        $rel2 = "";
      }



      $data['total'] = DB::table('sales')
        ->select(
          DB::raw("(select sum(sales.amount) from sales $rel2) as sales_amount"),
          DB::raw("(select sum((sales.amount*sales.tax)/100) from sales $rel2) as sales_tax"),
          DB::raw("(select sum(transaction.amount) from transaction, sales where sales.id = transaction.salesid $rel) as tran_amount"),
          DB::raw("(select sum(transaction.tax) from transaction, sales where sales.id = transaction.salesid $rel) as tran_tax"),
          DB::raw("(select sum(transaction.discount) from transaction, sales where sales.id = transaction.salesid $rel) as tran_discount")
        )
        ->first();
    }

    return view('admincontrol.invoice.invoice-partial-print')->with($data);
  }

  public function due(Request $request)
  {
    $data['title'] = "All Due Invoice";
    $data['customerid'] = $request->input("customerid");
    $data['start_date'] = $request->input("start_date");
    $data['end_date'] = $request->input("end_date");
    $search = $request->input("search");
    $data['customers'] = DB::table("customers")->orderBy("company_name")->get();

    if ($search) {
      $sql = DB::table('sales')
        ->select('sales.*', 'customers.company_name', 'customers.contact_person')
        ->join("customers", "customers.id", "=", "sales.customerid")
        ->where("sales.projectid", "=", 0)
        ->where("sales.due_date", "<", date("Y-m-d"));

      $rel = "";
      if ($data['customerid'] > 0) {
        $sql->where("customers.id", $data['customerid']);
        $rel .= " and sales.customerid='" . $data['customerid'] . "'";
      }
      if ($data['start_date'] != "" && $data['end_date'] != "") {
        $sql->where("sales.due_date", ">=", $data['start_date']);
        $sql->where("sales.due_date", "<=", $data['end_date']);

        $rel .= " and sales.due_date >= '" . $data['start_date'] . "'";
        $rel .= " and sales.due_date <= '" . $data['end_date'] . "'";
      } else if ($data['start_date'] != "") {
        $sql->where("sales.due_date", "=", $data['start_date']);
        $rel .= " and sales.due_date='" . $data['start_date'] . "'";
      } else if ($data['end_date'] != "") {
        $sql->where("sales.due_date", "=", $data['end_date']);
        $rel .= " and sales.due_date='" . $data['end_date'] . "'";
      }

      $rel = "(select sum(sales.amount) from sales where sales.due_date < '" . date("Y-m-d") . "' $rel) as total_amount";
      $data['due'] = DB::table('sales')
        ->select(DB::raw($rel))
        ->first();

      $data['allInvoice'] = $sql->orderBy("sales.id", "desc")
        ->paginate();
    } else {
      $data['allInvoice'] = DB::table('sales')
        ->select('sales.*', 'customers.company_name', 'customers.contact_person')
        ->join("customers", "customers.id", "=", "sales.customerid")
        ->where("sales.projectid", "=", 0)
        ->where("sales.due_date", "<", date("Y-m-d"))
        ->orderBy("sales.id", "desc")
        ->paginate();

      $rel = "(select sum(sales.amount) from sales where sales.due_date < '" . date("Y-m-d") . "') as total_amount";
      $data['due'] = DB::table('sales')
        ->select(DB::raw($rel))
        ->first();
    }
    return view('admincontrol.invoice.invoice-due-all')->with($data);
  }


  public function print_preview(Request $request, $id)
  {
    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();

    $data['paidAmount'] = DB::table("transaction")
      ->select(
        DB::raw('SUM(amount) as total_paid'),
        DB::raw('SUM(tax) as total_tax'),
        DB::raw('SUM(vat) as total_vat'),
        DB::raw('SUM(discount) as total_discount')
      )
      ->where("salesid", $id)
      ->first();

    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    $data['selected'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person', 'customers.address as caddress', 'customers.email', 'customers.contact_number', 'customers.designation')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.id", "=", $id)
      ->orderBy("sales.id", "desc")
      ->first();

    $data['details'] = DB::table("products as p")
      ->select(
        "ssd.price",
        "p.title",
        "p.id",
        "u.name as uname",
        "ssd.description as ssd_description",
        "ssd.quantity1"
      )
      ->join("sales_details as ssd", "ssd.productsid", "=", "p.id")
      ->join("units as u", "u.id", "=", "p.unitid")
      ->where("ssd.salesid", "=", $id)
      ->orderBy("ssd.id", "asc")
      ->get();

    $data['transaction'] = DB::table('transaction')->where("salesid", "=", $id)->get();
    $data['top_sheet'] = DB::table('transaction')
      ->where("invoice_start", "<=", $data['selected']->invoice_number)
      ->where("invoice_end", ">=", $data['selected']->invoice_number)
      ->where("customer_id", $data['selected']->customerid)
      ->first();

    $data['allService'] = DB::table('service_details')->select('*')->where("salesid", "=", $id)->orderBy("id", "ASC")->get();
    return view('admincontrol.invoice.invoice')->with($data);
  }

  public function print(Request $request, $id)
  {
    $data['paidAmount'] = DB::table("transaction")
      ->select(
        DB::raw('SUM(amount) as total_paid'),
        DB::raw('SUM(tax) as total_tax'),
        DB::raw('SUM(vat) as total_vat'),
        DB::raw('SUM(discount) as total_discount')
      )
      ->where("salesid", $id)
      ->first();
    $data['iid'] = $id;
    $data['selected'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.designation', 'customers.contact_person', 'customers.address as caddress', 'customers.email', 'customers.contact_number')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.id", "=", $id)
      ->orderBy("sales.id", "desc")
      ->first();

    $data['details'] = DB::table("products as p")
      ->select(
        "ssd.price",
        "p.title",
        "p.id",
        "u.name as uname",
        "p.description as ssd_description",
        "ssd.quantity1"
      )
      ->join("sales_details as ssd", "ssd.productsid", "=", "p.id")
      ->join("units as u", "u.id", "=", "p.unitid")
      ->where("ssd.salesid", "=", $id)
      ->orderBy("ssd.id", "asc")
      ->get();

    $data['allService'] = DB::table('service_details')->select('*')->where("salesid", "=", $id)->orderBy("id", "ASC")->get();
    if ($request->has('download')) {
      $pdf = PDF::loadView('admincontrol.invoice.invoice-print-download', compact('data'));
      return $pdf->download('pdfview.pdf');
    }
    return view('admincontrol.invoice.invoice-print')->with($data);
  }

  public function create(Request $request)
  {
    $data['product'] = DB::table('products')->orderBy("title", "asc")->select('*')->get();
    $data['customers'] = DB::table('customers')->select('*')->where("status", "=", 1)->orderBy("company_name", "asc")->get();
    $data['payment_term'] = [0, 3, 5, 7, 10, 15, 30, 45, 60, 90];
    $data['sales_tax'] = [0, 1, 1.5, 2, 3, 5, 7.5, 10, 15, 18];

    return view('admincontrol.invoice.invoice-new')->with($data);
  }

  public function store(Request $request)
  {
    $product = $request->input("product");
    $qty = $request->input("qty");
    $qty2 = $request->input("qty2");
    $des = $request->input("des");
    $price = $request->input("price");

    $due_date = date("Y-m-d", strtotime("+" . $request->input("due_date") . " days", strtotime($request->input("invoice_date"))));

    $challan = "";
    $challan_no = $request->input("challan_no");
    $challan_date = $request->input("challan_date");
    for ($i = 0; $i < count($challan_no); $i++) {
      if ($challan_no[$i] != "" && $challan_date[$i] != "") {
        if ($challan) {
          $challan .= "####";
        }
        $challan .= "||{$challan_no[$i]}||||{$challan_date[$i]}";
      }
    }
    /*
              echo $challan;
              echo "<pre>";
              print_r($challan_no);
              print_r($challan_date);
              die();
              */


    $salesData = [
      "customerid" => $request->input("customerid"),
      "projectid" => 0,
      "subject" => $request->input("subject"),
      "address" => $request->input("address"),
      "due_date" => $due_date,
      "invoice_number" => $request->input("invoice_number"),
      "invoice_prefix" => $request->input("invoice_prefix"),
      "challan" =>  $challan,
      "work_order" =>  $request->input("work_order"),
      "tax" => $request->input("tax"),
      "usersid" => Auth::user()->id,
      "created_at" => $request->input("invoice_date") . " 00:00:00",
      "address" => $request->input("address")
    ];

    if (Auth::user()->type == 2) {
      $salesData['verified'] = 1;
    }

    $sid = DB::table("sales")->insertGetId($salesData);
    //$sid = 6;
    $amount = 0;


    if ($product && count($product) > 0 && $product[0] > 0) {
      foreach ($product as $key => $value) {
        $sd = [
          "salesid" => $sid,
          "productsid" => $product[$key],
          "description" => $des[$key],
          "price" => $price[$key],
          "original_qty" => $qty[$key],
          "quantity1" => $qty[$key],
          "quantity2" => 0
        ];
        $amount += $price[$key] * $qty[$key];
        DB::table("sales_details")->insertGetId($sd);
      }
    }

    $service_details = $request->input("service_details");
    $service_quantity = $request->input("service_quantity");
    $type = $request->input("type");
    $service_amount = $request->input("service_amount");

    if ($service_details) {
      foreach ($service_details as $sd_key => $sd_value) {
        if ($sd_value) {
          $service_details_data = [
            "salesid" =>  $sid,
            "title" => $sd_value,
            "quantity" => $service_quantity[$sd_key],
            "type" => $type[$sd_key],
            "amount" => $service_amount[$sd_key]
          ];
          DB::table("service_details")->insert($service_details_data);
          $amount += ($service_quantity[$sd_key] * $service_amount[$sd_key]);
        }
      }
    }

    //echo $amount;
    $upd = [
      "total_amount" => $amount,
      "amount" => $amount - $request->input("discount"),
      "discount" => $request->input("discount")
    ];
    DB::table("sales")->where('id', $sid)->update($upd);
    return redirect()->route('invoice')->with('msg', 'Save Successfully');
  }

  public function edit(Request $request, $id)
  {
    $data['product'] = DB::table('products')->select('*')->get();
    $data['customers'] = DB::table('customers')->select('*')->where("status", "=", 1)->orderBy("company_name", "asc")->get();
    $data['payment_term'] = [0, 3, 5, 7, 10, 15, 30, 45, 60, 90];
    $data['sales_tax'] = [0, 1, 1.5, 2, 3, 5, 7.5, 10, 15, 18];
    $data['sales'] = DB::table('sales')->select('*')->where("id", "=", $id)->first();
    $data['sales_details'] = DB::table('sales_details')->select('sales_details.*', 'products.id as pid')
      ->join("products", "products.id", "=", "sales_details.productsid")
      ->where("sales_details.salesid", "=", $id)
      ->orderBy("sales_details.id", "ASC")
      ->get();
    $data['service_details'] = DB::table('service_details')->select('*')->where("salesid", "=", $id)->orderBy("id", "ASC")->get();

    return view('admincontrol.invoice.invoice-edit')->with($data);
  }

  public function update(Request $request)
  {
    $sid = $request->input("sid");
    $product = $request->input("product");
    $des = $request->input("des");
    $qty = $request->input("qty");
    $qty2 = $request->input("qty2");
    $price = $request->input("price");

    $due_date = date("Y-m-d", strtotime("+" . $request->input("due_date") . " days", strtotime($request->input("invoice_date"))));

    $challan = "";
    $challan_no = $request->input("challan_no");
    $challan_date = $request->input("challan_date");
    for ($i = 0; $i < count($challan_no); $i++) {
      if ($challan_no[$i] != "" && $challan_date[$i] != "") {
        if ($challan) {
          $challan .= "####";
        }
        $challan .= "||{$challan_no[$i]}||||{$challan_date[$i]}";
      }
    }

    $salesData = [
      "customerid" => $request->input("customerid"),
      "projectid" => 0,
      "subject" => $request->input("subject"),
      "address" => $request->input("address"),
      "due_date" => $due_date,
      "invoice_number" => $request->input("invoice_number"),
      "invoice_prefix" => $request->input("invoice_prefix"),
      "challan" =>  $challan,
      "work_order" =>  $request->input("work_order"),
      "tax" => $request->input("tax"),
      "usersid" => Auth::user()->id,
      "created_at" => $request->input("invoice_date") . " 00:00:00",
      "address" => $request->input("address")
    ];

    if (Auth::user()->type == 2) {
      $salesData['verified'] = 1;
    }

    DB::table("sales")->where("id", $sid)->update($salesData);

    DB::table("sales_details")->where("salesid", $sid)->delete();
    DB::table("service_details")->where("salesid", $sid)->delete();

    $amount = 0;

    if ($product) {
      foreach ($product as $key => $value) {
        $sd = [
          "salesid" => $sid,
          "productsid" => $product[$key],
          "description" => $des[$key],
          "price" => $price[$key],
          "original_qty" => $qty[$key],
          "quantity1" => $qty[$key],
          "quantity2" => 0
        ];
        $amount += $price[$key] * $qty[$key];
        DB::table("sales_details")->insert($sd);
      }
    }

    $service_details = $request->input("service_details");
    $service_quantity = $request->input("service_quantity");
    $type = $request->input("type");
    $service_amount = $request->input("service_amount");

    if ($service_details) {
      foreach ($service_details as $sd_key => $sd_value) {
        if ($sd_value) {
          $service_details_data = [
            "salesid" =>  $sid,
            "title" => $sd_value,
            "quantity" => $service_quantity[$sd_key],
            "type" => $type[$sd_key],
            "amount" => $service_amount[$sd_key]
          ];
          DB::table("service_details")->insert($service_details_data);
          $amount += ($service_quantity[$sd_key] * $service_amount[$sd_key]);
        }
      }
    }

    $upd = [
      "total_amount" => $amount,
      "amount" => $amount - $request->input("discount"),
      "discount" => $request->input("discount")
    ];
    DB::table("sales")->where('id', $sid)->update($upd);
    return redirect()->route('invoice')->with('msg', 'Save Successfully');
  }

  public function payment_save(Request $request)
  {
    $id = $request->iid;
    $sdata = [
      "bankid" => $request->bankid,
      "date" => $request->date,
      "description" => $request->description,
      "amount" => $request->amount,
      "tax" => $request->tax,
      "vat" => $request->vat,
      "discount" => $request->discount,
      "method" => $request->method,
      "type" => 1,
      "salesid" => $id,
    ];

    DB::table("transaction")->insert($sdata);
    DB::table("sales")->where('id', $id)->update(['status' => $request->input('status')]);
    return redirect()->route('invoice.printPreview', $id)->with('msg', 'Save Successfully');
  }

  public function payment_update(Request $request)
  {
    $id = $request->iid;
    $tranId = $request->tranId;
    $sdata = [
      "bankid" => $request->bankid,
      "date" => $request->date,
      "description" => $request->description,
      "amount" => $request->amount,
      "tax" => $request->tax,
      "vat" => $request->vat,
      "discount" => $request->discount,
      "method" => $request->method,
      "type" => 1,
      "salesid" => $id
    ];

    DB::table("transaction")->where('id', $tranId)->update($sdata);
    DB::table("sales")->where('id', $id)->update(['status' => $request->input('status')]);
    return redirect()->route('invoice.printPreview', $id)->with('msg', 'Update Successfully');
  }

  public function delete(Request $request, $sid)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("sales_details")->where("salesid", $sid)->delete();
    DB::table("service_details")->where("salesid", $sid)->delete();
    DB::table("sales")->where("id", $sid)->delete();
    DB::table("transaction")->where("salesid", ">", 0)->where("salesid", $sid)->delete();
    return redirect()->route('invoice')->with('msg', 'Delete Successfully');
  }
  public function payment_delete(Request $request, $sid)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $transaction = DB::table('transaction')->where("id", "=", $sid)->first();
    DB::table("transaction")->where("id", $sid)->delete();
    $transactions = DB::table('transaction')->where("salesid", "=", $transaction->salesid)->first();
    if (!isset($transactions->id)) {
      DB::table("sales")->where('id', $sid)->update(['status' => 0]);
    }

    return redirect()->route('invoice.printPreview', $transaction->salesid)->with('msg', 'Payment Delete Successfully');
  }

  public function get_product_description(Request $request)
  {
    $data = DB::table("products")->find($request->pdtid);
    //echo $data->description;
  }

  public function top_sheet(Request $request)
  {
    $data['customers'] = DB::table("customers")->orderBy("company_name")->get();
    $data['banks'] = DB::table("banks")->orderBy("name")->get();
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    return view('admincontrol.invoice.top-sheet')->with($data);
  }

  public function top_sheet_search(Request $request)
  {
    $start = $request->input("start");
    $end = $request->input("end");
    $customerid = $request->input("customerid");


    $data = DB::table("sales")
      ->where('invoice_number', ">=", $start)
      ->where('invoice_number', "<=", $end)
      ->where('customerid', $customerid)
      ->get();

    if (count($data) < 1) {
      echo -1;
      die();
    }

    $amount = 0;
    foreach ($data as $key => $value) {
      if ($value->status == 1) {
        echo 0;
        die();
      }
      $amount += $value->amount;
    }
    echo $amount;
  }

  public function top_sheet_save(Request $request)
  {
    $start = $request->input("start");
    $end = $request->input("end");
    $customerid = $request->input("customerid");

    $amount = $request->input("amount");
    $vat = $request->input("vat");
    $tax = $request->input("tax");

    $data = DB::table("sales")
      ->where('invoice_number', ">=", $start)
      ->where('invoice_number', "<=", $end)
      ->where('customerid', $customerid)
      ->get();

    $total_amount = 0;
    foreach ($data as $key => $value) {
      $total_amount += $value->amount;
      DB::table("sales")->where("id", $value->id)->update(["status" => 1]);
    }
    $discount = $total_amount - ($amount + $vat + $tax);

    $sdata = [
      "bankid" => $request->input("bankid"),
      "date" => $request->input("date"),
      "description" => $request->input("description"),
      "amount" => $amount,
      "tax" => $tax,
      "vat" => $vat,
      "discount" => $discount,
      "method" => $request->input("method"),
      "type" => 1,
      "salesid" => 1,
      "invoice_start" => $start,
      "invoice_end" => $end,
      "customer_id" => $customerid
    ];

    DB::table("transaction")->insert($sdata);

    return redirect()->back()->with("msg", "Save Successfully");
  }


  public function top_sheet_all(Request $request)
  {
    $data['transaction'] = DB::table("transaction")
      ->select("transaction.*", "customers.company_name", "customers.contact_person")
      ->join("customers", "customers.id", "=", "transaction.customer_id")
      ->where("transaction.invoice_start", ">", 0)
      ->where("transaction.invoice_end", ">", 0)
      ->where("transaction.salesid", 1)
      ->orderBy("transaction.id", 'desc')
      ->paginate(30);
    return view('admincontrol.invoice.top-sheet-all')->with($data);
  }

  public function top_sheet_delete(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $selected = DB::table("transaction")->find($id);
    if (!$selected) {
      return redirect()->back();
    }
    $data = DB::table("sales")
      ->where('invoice_number', ">=", $selected->invoice_start)
      ->where('invoice_number', "<=", $selected->invoice_end)
      ->where('customerid', $selected->customer_id)
      ->get();

    foreach ($data as $key => $value) {
      DB::table("sales")->where('id', $value->id)->update(['status' => 0]);
    }
    DB::table("transaction")->where('id', $id)->delete();
    return redirect()->back()->with(["msg" => "Delete Successfully"]);
  }

  public function top_sheet_print(Request $request, $id)
  {
    $selected = DB::table("transaction")->find($id);
    if (!$selected) {
      return redirect()->back();
    }
    $data['sales'] = DB::table("sales")
      ->select("sales.*", "customers.company_name", "customers.contact_person")
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where('invoice_number', ">=", $selected->invoice_start)
      ->where('invoice_number', "<=", $selected->invoice_end)
      ->where('customerid', $selected->customer_id)
      ->get();
    $data['selected'] = $selected;

    return view('admincontrol.invoice.top-sheet-print')->with($data);
  }

  //Custom top sheet start
  public function custom_top_sheet(Request $request)
  {
    $data['customers'] = DB::table("customers")->orderBy("company_name")->get();
    $data['banks'] = DB::table("banks")->orderBy("name")->get();
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    return view('admincontrol.invoice.custom-top-sheet')->with($data);
  }

  public function custom_top_sheet_search(Request $request)
  {
    $invoice_number = explode(',', $request->input("invoice_number"));
    $customerid = $request->input("customerid");


    $data = DB::table("sales")
      ->whereIn('invoice_number', $invoice_number)
      ->where('customerid', $customerid)
      ->get();

    if (count($data) < 1) {
      echo -1;
      die();
    }

    $amount = 0;
    foreach ($data as $key => $value) {
      if ($value->status == 1) {
        echo 0;
        die();
      }
      $amount += $value->amount;
    }
    echo $amount;
  }

  public function custom_top_sheet_save(Request $request)
  {
    $invoice_number = explode(',', $request->input("invoice_number"));
    $customerid = $request->input("customerid");

    $amount = $request->input("amount");
    $vat = $request->input("vat");
    $tax = $request->input("tax");

    $data = DB::table("sales")
      ->whereIn('invoice_number', $invoice_number)
      ->where('customerid', $customerid)
      ->get();

    $total_amount = 0;
    foreach ($data as $key => $value) {
      $total_amount += $value->amount;
      DB::table("sales")->where("id", $value->id)->update(["status" => 1]);
    }
    $discount = $total_amount - ($amount + $vat + $tax);

    $sdata = [
      "bankid" => $request->input("bankid"),
      "date" => $request->input("date"),
      "description" => $request->input("description"),
      "amount" => $amount,
      "tax" => $tax,
      "vat" => $vat,
      "discount" => $discount,
      "method" => $request->input("method"),
      "type" => 1,
      "salesid" => 1,
      "customer_id" => $customerid
    ];

    DB::table("transaction")->insert($sdata);

    return redirect()->back()->with("msg", "Save Successfully");
  }
}
