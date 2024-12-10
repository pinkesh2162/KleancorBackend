<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProductsController extends Controller
{

  public function index()
  {
    Auth::user()->id;
    //die();
    $data['company'] = DB::table('customers')
      ->select('*')
      ->get();

    $data['units'] = DB::table('units')
      ->select('*')
      ->get();
    $data['title'] = "Insert Product";
    return view('products.new', $data);
  }

  public function create(Request $request)
  {

    $validationRules =
      [
        'title' => 'required|max:100',
        'description' => 'required|max:255',
        'date' => 'required',
      ];

    $customMessage = [
      'title.required' => 'Title is required.',
      'description.required' => 'Description is required.',
      'date.required' => 'Created Date is required.',

    ];

    $tableData = [
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'userid' => Auth::user()->id,
      'unitid' => $request->get('units'),
      'created_at' => $request->input('date')
    ];

    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }



    $insert = DB::table('products')
      ->insert($tableData);

    if (!$insert) {
      return redirect()->back()->with('msg', 'Invalid information, Not Inserted!!');
    }
    return redirect()->back()->with('error', 'Inserted Successfully!!');
  }

  public function show(Request $request)
  {
    $data['title'] = "Active Product";
    $data['product'] = DB::table('products')
      ->join('units', 'products.unitid', '=', 'units.id')
      ->join('users', 'products.userid', '=', 'users.id')
      ->leftJoin('addproducts', 'addproducts.productid', '=', 'products.id')
      ->select(
        'products.*',
        'units.name as unitname',
        'users.name',
        DB::raw('(select sum(addproducts.stock) from addproducts where addproducts.productid = products.id) as totalStock'),
        DB::raw('(select sum(stock_out.stock) from stock_out where products.id = stock_out.productsid) as totalSales')
      )
      ->where("products.status", 1)
      ->groupBy("products.id")
      ->orderBy("products.title", "asc")
      ->paginate(30);
    return view('products.view', $data);
  }

  public function frozen(Request $request)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['title'] = "Frozen Product";
    $data['product'] = DB::table('products')
      ->join('units', 'products.unitid', '=', 'units.id')
      ->join('users', 'products.userid', '=', 'users.id')
      ->leftJoin('addproducts', 'addproducts.productid', '=', 'products.id')
      ->select(
        'products.*',
        'units.name as unitname',
        'users.name',
        DB::raw('(select sum(addproducts.stock) from addproducts where addproducts.productid = products.id) as totalStock'),
        DB::raw('(select sum(sales_details.quantity1) from sales_details where addproducts.id = sales_details.addproductsid and sales_details.quantity2 = 0) as totalSales1'),
        DB::raw('(select sum(sales_details.quantity2) from sales_details where addproducts.id = sales_details.addproductsid) as totalSales2')
      )
      ->where("products.status", 0)
      ->groupBy("products.id")
      ->paginate(30);
    return view('products.view', $data);
  }

  public function sellerReport(Request $request, $id)
  {
    $sdate = $request->get("sdate");
    $edate = $request->get("edate");


    $query = DB::table('addproducts')
      ->join('customers', 'addproducts.customerid', '=', 'customers.id')
      ->join('products', 'addproducts.productid', '=', 'products.id')
      //->join('banks', 'addproducts.bank_id', '=', 'banks.id')
      ->where("products.id", $id)
      //->select('addproducts.*', 'products.title as pname', 'customers.company_name' , 'products.title')
      ->select("addproducts.id", "addproducts.vat as pvat", "customers.company_name as custoname", "products.title as pname", "addproducts.created_at", "addproducts.stock", "addproducts.price")
      ->orderBy("products.title", "asc")
      ->orderBy("addproducts.created_at", "desc");
    if ($sdate && $edate) {
      $query->where("addproducts.created_at", ">=", $sdate);
      $query->where("addproducts.created_at", "<=", $edate);
    } else if ($sdate) {
      $query->where("addproducts.created_at", $sdate);
    } else if ($edate) {
      $query->where("addproducts.created_at", $date);
    }

    $data['title'] = "View Seller Report";
    $data['newproduct'] = $query->paginate(30);
    return view('products.seller-report', $data);
  }

  public function edit($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['title'] = "Update Product";

    $data['userid'] = $id;
    $data['units'] = DB::table('units')
      ->select('*')
      ->get();

    $data['product'] = DB::table('products')
      ->where('id', "=", $id)
      ->first();
    return view('products.edit', $data);
  }

  public function update(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }

    $validationRules =
      [
        'title' => 'required',
        'description' => 'required',
        'date' => 'required',

      ];

    $customMessage = [
      'title.required' => 'Name is required.',
      'description.required' => 'designation is required.',
      'date.required' => 'Create Date is required.',

    ];

    $tableData = [

      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'userid' => Auth::user()->id,
      'unitid' => $request->get('units'),
      'updated_at' => $request->input('date'),
      'status' => $request->input('status'),
    ];

    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $update = DB::table('products')
      ->where('id', $id)
      ->update($tableData);

    if (!$update) {
      return redirect()->back()->with('error', 'Information Not Updated!!');
    }
    return redirect()->route('product.view')->with('msg', 'Information is Updated Successfully!!!');
    //return redirect()->route('allusers')->with('msg', 'Information is Updated Successfully!');
  }

  public function delete($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $delete = DB::table('products')
      ->where("id", "=", "$id")
      ->delete();

    if (!$delete) {
      return redirect()->back()->with('error', 'Not Deleted!!');
    }

    return redirect()->route('product.view')->with('msg', 'Deleted Successfully!');
  }
}
