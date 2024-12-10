<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller {

  public function index() {
    $data['title'] = "Insert Customer";
    return view('admincontrol.customers.customers-reg', $data);
  }

  public function create(Request $request) {

    $validationRules = [
      'company' => 'required|max:100',
      'address' => 'required|max:100',
      'email' => 'required|max:50',
      'number' => 'required|max:13',
      'conperson' => 'required|max:50',
      'designation' => 'required|max:50',
      'date' => 'required',
    ];

    $customMessage = [
      'company.required' => 'Company Name is required.',
      'address.required' => 'Address is required.',
      'email.required' => 'Email is required.',
      'number.required' => 'Contact Number is required',
      'number.required|max:13' => 'Contact Number is maximum 13 character ',
      'conperson.required' => 'Contact Person is required',
      'designation.required' => 'Designation is required',
      'date' => 'Created Date is required',
    ];

    $tableData = [
      'company_name' => $request->input('company'),
      'address' => $request->input('address'),
      'email' => $request->input('email'),
      'contact_number' => $request->input('number'),
      'contact_person' => $request->input('conperson'),
      'designation' => $request->input('designation'),
      'status' => 1,
      'verified' => 0,
      'created_at' => $request->input('date'),
    ];

    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $insert = DB::table('customers')
    ->insert($tableData);

    if (!$insert) {
      return redirect()->back()->with('msg', 'Invalid information, Not Inserted!!');
    }
    return redirect()->back()->with('error', 'Inserted Successfully!!');
  }

  public function view() {
    $data['company'] = DB::table('customers')
    ->leftJoin("addproducts", "addproducts.customerid", "=", "customers.id")
    ->where('customers.status', '=', 1)
    ->select('customers.*', DB::raw('(select sum(addproducts.stock) from addproducts where addproducts.customerid = customers.id) as totalStock'))->groupBy('customers.id')
    ->groupBy("customers.id")
    ->paginate(30);

    $data['title'] = "View Customer";
    return view('admincontrol.customers.all-customers', $data);
  }

  public function details(Request $request, $id) {
    $data['customers'] = DB::table('customers')->find($id);

    $data['sdate'] = $request->input("sdate");
    $data['edate'] = $request->input("edate");

    if($data['sdate'] || $data['edate']){
      $newproduct = DB::table('addproducts')
      ->join('customers', 'addproducts.customerid', '=', 'customers.id')
      ->join('products', 'addproducts.productid', '=', 'products.id')
      ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
      ->select('addproducts.*', 'customers.company_name' , 'products.title', 'banks.name',
      DB::raw('(select sum(sales_details.quantity1) from sales_details where addproducts.id = sales_details.addproductsid and sales_details.quantity2 = 0) as totalSales1'),
      DB::raw('(select sum(sales_details.quantity2) from sales_details where addproducts.id = sales_details.addproductsid) as totalSales2')
      )
      ->where("addproducts.status", 1);
      if($data['sdate'] && $data['edate']){
        $newproduct->where('addproducts.created_at', ">=",$data['sdate']);
        $newproduct->where('addproducts.created_at', "<=",$data['edate']);
      }
      else if($data['sdate']){
        $newproduct->where('addproducts.created_at', $data['sdate']);
      }
      else if($data['edate']){
        $newproduct->where('addproducts.created_at', $data['edate']);
      }

      $data['newproduct'] = $newproduct->orderBy("products.title", "ASC")
      ->orderBy("addproducts.id", "ASC")
      ->paginate(20);


      $where = $where2 = "addproducts, products, customers where addproducts.productid = products.id and addproducts.customerid = customers.id and addproducts.customerid={$id}";

      if($data['sdate'] && $data['edate']){
        $where .= " and addproducts.created_at >= '".$data['sdate']."'";
        $where .= " and addproducts.created_at <= '".$data['edate']."'";

        $where2 .= " and addproducts.created_at < '".$data['sdate']."'";
      }
      else if($data['sdate']){
        $where .= " and addproducts.created_at = '".$data['sdate']."'";
        $where2 .= " and addproducts.created_at < '".$data['sdate']."'";
      }
      else if($data['edate']){
        $where .= " and addproducts.created_at = '".$data['edate']."'";
        $where2 .= " and addproducts.created_at < '".$data['edate']."'";
      }

      $data['totalAmount'] = DB::table('addproducts')
      ->select(
        DB::raw("(select sum(addproducts.amount * addproducts.stock) from $where) as total_amount"),
        DB::raw("(select sum(addproducts.cash) from $where) as total_cash"),
        DB::raw("(select sum(addproducts.due) from $where) as total_due"),
        DB::raw("(select sum(addproducts.bank_amount) from $where) as total_bank_amount")
        )
        ->where("addproducts.customerid", $id)
        ->first();

        $data['totalAmount2'] = DB::table('addproducts')
        ->select(
          DB::raw("(select sum(addproducts.amount * addproducts.stock) from $where2) as total_amount"),
          DB::raw("(select sum(addproducts.cash) from $where2) as total_cash"),
          DB::raw("(select sum(addproducts.due) from $where2) as total_due"),
          DB::raw("(select sum(addproducts.bank_amount) from $where2) as total_bank_amount")
          )
          ->where("addproducts.customerid", $id)
          ->first();

        $data['pdtid'] = 0;
    }
    else{
      $data['newproduct'] = DB::table('addproducts')
      ->join('customers', 'addproducts.customerid', '=', 'customers.id')
      ->join('products', 'addproducts.productid', '=', 'products.id')
      ->leftJoin('banks', 'addproducts.bank_id', '=', 'banks.id')
      ->select('addproducts.*', 'customers.company_name' , 'products.title', 'banks.name',
      DB::raw('(select sum(sales_details.quantity1) from sales_details where addproducts.id = sales_details.addproductsid and sales_details.quantity2 = 0) as totalSales1'),
      DB::raw('(select sum(sales_details.quantity2) from sales_details where addproducts.id = sales_details.addproductsid) as totalSales2')
      )
      ->where("addproducts.status", 1)
      ->where("addproducts.customerid", $id)
      ->orderBy("products.title", "ASC")
      ->orderBy("addproducts.id", "ASC")
      ->paginate(20);


      $where = "addproducts, products, customers where addproducts.productid = products.id and addproducts.customerid = customers.id and addproducts.customerid={$id}";

      $data['totalAmount'] = DB::table('addproducts')
      ->select(
        DB::raw("(select sum(addproducts.amount * addproducts.stock) from $where) as total_amount"),
        DB::raw("(select sum(addproducts.cash) from $where) as total_cash"),
        DB::raw("(select sum(addproducts.due) from $where) as total_due"),
        DB::raw("(select sum(addproducts.bank_amount) from $where) as total_bank_amount")
        )
        ->where("addproducts.customerid", $id)
        ->first();

        $data['pdtid'] = 0;
      }

      $data['title'] = "View Customer Report";
      return view('admincontrol.customers.customer-report', $data);
    }

    public function viewdetails(Request $request, $id) {
      $sdate = $request->get("sdate");
      $edate = $request->get("edate");

      $query = DB::table('addproducts')
      ->join('customers', 'addproducts.customerid', '=', 'customers.id')
      ->join('products', 'addproducts.productid', '=', 'products.id')
      ->where("customers.id", '=', $id)
      ->select('customers.id', DB::raw('(select sum(addproducts.amount) from addproducts where addproducts.customerid = customers.id) as totalAmount'))
      ->select("addproducts.vat", "addproducts.id", "addproducts.price", "addproducts.stock as addstok", "addproducts.amount as adproPurchamount", "products.title as pname", "addproducts.created_at as adpDate", 'customers.company_name as cusName', 'customers.contact_person as custName')
      ;
      if ($sdate && $edate) {
        $query->where("addproducts.created_at", ">=", $sdate);
        $query->where("addproducts.created_at", "<=", $edate);
      } else if ($sdate) {
        $query->where("addproducts.created_at", $sdate);
      } else if ($edate) {
        $query->where("addproducts.created_at", $date);
      }

      $data['company'] = $query->paginate(30);
      $data['title'] = "View Search Customer";
      return view('admincontrol.customers.customers-all-product', $data);
    }

    public function viewfrozen() {

      $data['company'] = DB::table('customers')
      ->where('customers.status', '=', 0)
      ->select('customers.*', DB::raw('(select sum(addproducts.stock) from addproducts where addproducts.customerid = customers.id) as totalStock'))->groupBy('customers.id')
      ->paginate(30);
      $data['title'] = "View Frozen Customer";
      return view('admincontrol.customers.all-frozen-customers', $data);
      /*
      $data['company'] = DB::table('customers')
      ->select('*')
      ->where('status','=',0)
      ->paginate(10);
      return view('admincontrol.customers.all-frozen-customers', $data);
      */
    }

    public function edit($id) {

      $data['company'] = DB::table('customers')
      ->where('id', "=", $id)
      ->first();
      if ($data['company']->verified == 1 && Auth::user()->type != 2) {
        return redirect()->route("allcustomers");
      }
      $data['title'] = "Update Customer";
      return view('admincontrol.customers.edit-customers', $data);
    }

    public function update(Request $request, $id) {


      $validationRules = [
        'company' => 'required|max:100',
        'address' => 'required|max:100',
        'email' => 'required|max:50',
        'number' => 'required|max:13',
        'conperson' => 'required|max:50',
        'designation' => 'required|max:50',
        'date' => 'required',
      ];

      $customMessage = [
        'company.required' => 'Company Name is required.',
        'address.required' => 'Address is required.',
        'email.required' => 'Email is required.',
        'number.required' => 'Contact Number is required',
        'number.required' => 'Contact Number is required',
        'conperson.required' => 'Contact Person is required',
        'designation.required' => 'Designation is required',
        'date.required' => 'Create Date is required',
      ];

      $tableData = [
        'company_name' => $request->input('company'),
        'address' => $request->input('address'),
        'email' => $request->input('email'),
        'contact_number' => $request->input('number'),
        'contact_person' => $request->input('conperson'),
        'designation' => $request->input('designation'),
        'status' => 1,
        'verified' => 0,
        'updated_at' => $request->input('date')
      ];

      $validateFormData = request()->validate($validationRules, $customMessage);

      if (!$validateFormData) {
        return redirect()->back()->withErrors($request->all());
      }

      if (Auth::user()->type == 2) {
        $tableData['verified'] = 1;
      } else {
        $company = DB::table('customers')
        ->where('id', "=", $id)
        ->first();
        if ($company->verified == 1) {
          return redirect()->route("allcustomers");
        }
      }

      $update = DB::table('customers')
      ->where('id', $id)
      ->update($tableData);

      if (!$update) {
        return redirect()->back()->with('error', 'Information Not Updated!!');
      }
      return redirect()->route('allcustomers')->with('msg', 'Information is Updated Successfully!!!');
      //return redirect()->route('allusers')->with('msg', 'Information is Updated Successfully!');
    }

    public function delete($id) {

      $delete = DB::table('customers')
      ->where("id", "=", "$id")
      ->delete();

      if (!$delete) {
        return redirect()->back()->with('error', 'Not Deleted!!');
      }

      return redirect()->route('allcustomers')->with('msg', 'Deleted Successfully!');
    }

    public function frozen($id) {
      $tableData = [
        'status' => 0
      ];

      $update = DB::table('customers')
      ->where('id', $id)
      ->update($tableData);

      if (!$update) {
        return redirect()->back()->with('error', 'Information Not Frozen!!');
      }
      return redirect()->back()->with('msg', 'Information is Frozen Successfully!!!');
    }

    public function active($id) {
      $tableData = [
        'status' => 1
      ];

      $update = DB::table('customers')
      ->where('id', $id)
      ->update($tableData);

      if (!$update) {
        return redirect()->back()->with('error', 'Information Not Active!!');
      }
      return redirect()->back()->with('msg', 'Information is Active Successfully!!!');
    }

  }
