<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\OurPayment;

class InvoiceProController extends Controller
{
  public function index()
  {
    $data['title'] = "All Invoice";
    $data['allInvoice'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.projectid", ">", 0)
      ->orderBy("sales.id", "desc")
      ->get();
    return view('admincontrol.invoice.invoice-pro-all')->with($data);
  }
  public function due()
  {
    $data['title'] = "All Due Invoice";
    $data['allInvoice'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.projectid", ">", 0)
      ->where("sales.due_date", "<", date("Y-m-d"))
      ->orderBy("sales.id", "desc")
      ->get();
    return view('admincontrol.invoice.invoice-pro-all')->with($data);
  }
  public function print_preview(Request $request, $id)
  {
    $data['banks'] = DB::table('banks')
      ->where("status", "=", 1)
      ->orderBy("name", "asc")
      ->get();
    $data['method'] = [
      "L/C", "T.T", "Pay Order", "Cash", "Cheque", "Electronics Transfer"
    ];

    $data['selected'] = DB::table('sales')
      ->select('sales.*', 'customers.company_name', 'customers.contact_person', 'customers.address as caddress', 'customers.email', 'customers.contact_number')
      ->join("customers", "customers.id", "=", "sales.customerid")
      ->where("sales.id", "=", $id)
      ->orderBy("sales.id", "desc")
      ->first();

    $data['details'] = DB::table("addproducts as ap")
      ->select(
        "ssd.price",
        "p.title",
        "p.id",
        "ap.id as apid",
        "u.name as uname",
        DB::raw("(select sum(sd.quantity1) from sales_details as sd, addproducts as aap where sd.addproductsid = aap.id and aap.productid = p.id and sd.salesid = $id) as totalSale")
      )
      ->join("sales_details as ssd", "ssd.addproductsid", "=", "ap.id")
      ->join("products as p", "p.id", "=", "ap.productid")
      ->join("units as u", "u.id", "=", "p.unitid")
      ->where("ssd.salesid", "=", $id)
      ->groupBy("p.id")
      ->orderBy("ssd.id", "asc")
      ->get();

    /*
      echo "<pre>";
      print_r($data['details']);
      die();
      */
    return view('admincontrol.invoice.invoice-pro')->with($data);
  }
  public function create(Request $request)
  {
    $data['product'] = DB::table('products')->select('*')->orderBy("title", "asc")->get();
    $data['project'] = DB::table('projects')
      ->select('projects.*', "customers.company_name")
      ->join("customers", "customers.id", "=", "projects.customerid")
      ->where("projects.status", "=", 1)
      ->get();
    $data['payment_term'] = [0, 3, 5, 7, 10, 15, 30, 45, 60, 90];
    $data['sales_tax'] = [0, 1, 1.5, 2, 3, 5, 7.5, 10, 15];

    return view('admincontrol.invoice.invoice-pro-new')->with($data);
  }

  public function store(Request $request)
  {
    $product = $request->input("product");
    $qty = $request->input("qty");
    $qty2 = $request->input("qty2");
    $price = $request->input("price");

    $project = DB::table("projects")->where("id", "=", $request->input("projectid"))->first();

    $due_date = date("Y-m-d", strtotime("+" . $request->input("due_date") . " days", strtotime($request->input("invoice_date"))));

    $salesData = [
      "customerid" => $project->customerid,
      "projectid" => $project->id,
      "subject" => $request->input("subject"),
      "address" => $request->input("address"),
      "due_date" => $due_date,
      "invoice_prefix" => $request->input("invoice_prefix"),
      "challan" =>  $request->input("challan"),
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

    foreach ($product as $key => $value) {
      $ap = DB::table("addproducts as ap")
        ->select(
          "ap.id",
          "ap.stock as totalStock",
          "ap.productid",
          DB::raw("(select sum(sd.quantity1) from sales_details as sd where sd.addproductsid = ap.id and sd.quantity2=0) as totalSale1"),
          DB::raw("(select sum(sd.quantity2) from sales_details as sd where sd.addproductsid = ap.id) as totalSale2")
        )
        ->where("ap.productid", "=", $value)
        ->orderBy("ap.created_at", "asc")
        ->get();

      /*
          echo "<pre>";
          print_r($ap);
          echo "</pre>";
          */

      if ($qty2[$key] > 0) {
        $temp_qty = $qty2[$key];
        $c = 1;
      } else {
        $temp_qty = $qty[$key];
        $c = 2;
      }
      $amount += $qty[$key] * $price[$key];

      foreach ($ap as $a) {
        if ($a->totalStock == $a->totalSale1 + $a->totalSale2) {
          continue; //Sold Out
        } else if (($a->totalStock >= ($temp_qty + $a->totalSale1 + $a->totalSale2))  && $temp_qty > 0) {
          $sd = [
            "salesid" => $sid,
            "addproductsid" => $a->id,
            "price" => $price[$key],
            "quantity1" => ($c == 2) ? $temp_qty : 0,
            "quantity2" => ($c == 1) ? $temp_qty : 0
          ];
          $sdids = DB::table("sales_details")->insertGetId($sd); //Quote Completed
          break;
        } else {
          $sd = [
            "salesid" => $sid,
            "addproductsid" => $a->id,
            "price" => $price[$key],
            "quantity1" => ($c == 2) ? $a->totalStock : 0,
            "quantity2" => ($c == 1) ? $a->totalStock : 0
          ];
          $sdids = DB::table("sales_details")->insertGetId($sd);
          $temp_qty = $temp_qty - $a->totalStock;
        }
      }

      if ($qty2[$key] > 0) {
        DB::table("sales_details")->where('id', $sdids)->update(["quantity1" => $qty[$key]]);
      }
    }

    if ($request->input("service_details1") && $request->input("service_amount1")) {
      $service_details = [
        "salesid" =>  $sid,
        "title" => $request->input("service_details1"),
        "quantity" => $request->input("service_quantiry1"),
        "amount" => $request->input("service_amount1")
      ];
      DB::table("service_details")->insert($service_details);
      $amount += ($request->input("service_quantiry1") * $request->input("service_amount1"));
    }
    if ($request->input("service_details2") && $request->input("service_amount2")) {
      $service_details = [
        "salesid" =>  $sid,
        "title" => $request->input("service_details2"),
        "quantity" => $request->input("service_quantiry2"),
        "amount" => $request->input("service_amount2")
      ];
      DB::table("service_details")->insert($service_details);
      $amount +=  ($request->input("service_quantiry2") * $request->input("service_amount2"));
    }

    DB::table("sales")->where('id', $sid)->update(["amount" => $amount]);
    return redirect()->route('invoice-pro')->with('msg', 'Save Successfully');
  }

  public function edit(Request $request, $id)
  {
    $data['product'] = DB::table('products')->select('*')->get();
    $data['project'] = DB::table('projects')
      ->select('projects.*', "customers.company_name")
      ->join("customers", "customers.id", "=", "projects.customerid")
      ->where("projects.status", "=", 1)
      ->get();
    $data['payment_term'] = [0, 3, 5, 7, 10, 15, 30, 45, 60, 90];
    $data['sales_tax'] = [0, 1, 1.5, 2, 3, 5, 7.5, 10, 15];
    $data['sales'] = DB::table('sales')->select('*')->where("id", "=", $id)->first();
    $data['sales_details'] = DB::table('sales_details')->select('sales_details.*', 'products.id as pid')
      ->join("addproducts", "addproducts.id", "=", "sales_details.addproductsid")
      ->join("products", "products.id", "=", "addproducts.productid")
      ->where("sales_details.salesid", "=", $id)
      ->groupBy("products.id")
      ->orderBy("sales_details.id", "ASC")
      ->get();
    $data['service_details'] = DB::table('service_details')->select('*')->where("salesid", "=", $id)->orderBy("id", "ASC")->get();

    return view('admincontrol.invoice.invoice-pro-edit')->with($data);
  }

  public function update(Request $request)
  {
    $sid = $request->input("sid");
    $product = $request->input("product");
    $qty = $request->input("qty");
    $qty2 = $request->input("qty2");
    $price = $request->input("price");

    $due_date = date("Y-m-d", strtotime("+" . $request->input("due_date") . " days", strtotime($request->input("invoice_date"))));

    $project = DB::table("projects")->where("id", "=", $request->input("projectid"))->first();

    $salesData = [
      "customerid" => $project->customerid,
      "projectid" => $request->input("projectid"),
      "subject" => $request->input("subject"),
      "address" => $request->input("address"),
      "due_date" => $due_date,
      "invoice_prefix" => $request->input("invoice_prefix"),
      "challan" =>  $request->input("challan"),
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
        $ap = DB::table("addproducts as ap")
          ->select(
            "ap.id",
            "ap.stock as totalStock",
            "ap.productid",
            DB::raw("(select sum(sd.quantity1) from sales_details as sd where sd.addproductsid = ap.id and sd.quantity2=0) as totalSale1"),
            DB::raw("(select sum(sd.quantity2) from sales_details as sd where sd.addproductsid = ap.id) as totalSale2")
          )
          ->where("ap.productid", "=", $value)
          ->orderBy("ap.created_at", "asc")
          ->get();

        /*
              echo "<pre>";
              print_r($ap);
              echo "</pre>";
              */

        if ($qty2[$key] > 0) {
          $temp_qty = $qty2[$key];
          $c = 1;
        } else {
          $temp_qty = $qty[$key];
          $c = 2;
        }

        $amount += $qty[$key] * $price[$key];

        foreach ($ap as $a) {
          if ($a->totalStock == $a->totalSale1 + $a->totalSale2) {
            continue; //Sold Out
          } else if (($a->totalStock >= ($temp_qty + $a->totalSale1 + $a->totalSale2))  && $temp_qty > 0) {
            $sd = [
              "salesid" => $sid,
              "addproductsid" => $a->id,
              "price" => $price[$key],
              "quantity1" => ($c == 2) ? $temp_qty : 0,
              "quantity2" => ($c == 1) ? $temp_qty : 0
            ];
            $sdids = DB::table("sales_details")->insertGetId($sd); //Quote Completed
            break;
          } else {
            $sd = [
              "salesid" => $sid,
              "addproductsid" => $a->id,
              "price" => $price[$key],
              "quantity1" => ($c == 2) ? $a->totalStock : 0,
              "quantity2" => ($c == 1) ? $a->totalStock : 0
            ];
            $sdids = DB::table("sales_details")->insertGetId($sd);
            $temp_qty = $temp_qty - $a->totalStock;
          }
        }

        if ($qty2[$key] > 0) {
          DB::table("sales_details")->where('id', $sdids)->update(["quantity1" => $qty[$key]]);
        }
      }
    }
    if ($request->input("service_details1") && $request->input("service_amount1")) {
      $service_details = [
        "salesid" =>  $sid,
        "title" => $request->input("service_details1"),
        "quantity" => $request->input("service_quantiry1"),
        "amount" => $request->input("service_amount1")
      ];
      DB::table("service_details")->insert($service_details);
      $amount +=  ($request->input("service_quantiry1") * $request->input("service_amount1"));
    }
    if ($request->input("service_details2") && $request->input("service_amount2")) {
      $service_details = [
        "salesid" =>  $sid,
        "title" => $request->input("service_details2"),
        "quantity" => $request->input("service_quantiry2"),
        "amount" => $request->input("service_amount2")
      ];
      DB::table("service_details")->insert($service_details);
      $amount += ($request->input("service_quantiry2") * $request->input("service_amount2"));
    }
    DB::table("sales")->where('id', $sid)->update(["amount" => $amount]);
    return redirect()->route('invoice-pro')->with('msg', 'Save Successfully');
  }

  public function payment_save(Request $request)
  {
    $id = $request->iid;
    $sdata = [
      "bankid" => $request->bankid,
      "date" => $request->date,
      "description" => $request->description,
      "amount" => $request->amount,
      "method" => $request->method,
      "type" => 1,
      "salesid" => $id,
    ];
    DB::table("transaction")->insert($sdata);
    DB::table("sales")->where('id', $id)->update(['status' => 1]);
    return redirect()->route('invoice-pro.printPreview', $id)->with('msg', 'Paid Successfully');
  }


  public function delete(Request $request, $sid)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("sales_details")->where("salesid", $sid)->delete();
    DB::table("service_details")->where("salesid", $sid)->delete();
    DB::table("sales")->where("id", $sid)->delete();
    return redirect()->route('invoice-pro')->with('msg', 'Delete Successfully');
  }
}
