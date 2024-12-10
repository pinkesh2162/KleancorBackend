<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StockOutController extends Controller
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

    $data['title'] = "Insert Stock Out";
    return view('stockout.new', $data);
  }

  public function create(Request $request)
  {
    $validationRules =
      [
        'stock' => 'required',
        'date' => 'required',
      ];

    $customMessage = [
      'stock.required' => 'Stock is required.',
      'date.required' => 'Created Date is required.',
    ];

    $tableData = [
      'productsid' => $request->input('product'),
      'stock' => $request->input('stock'),
      'challan' => $request->input('challan'),
      'description' => $request->input('description'),
      'created_at' => $request->input('date')
    ];
    $validateFormData = request()->validate($validationRules, $customMessage);

    if (!$validateFormData) {
      return redirect()->back()->withErrors($request->all());
    }

    $insert = DB::table('stock_out')
      ->insert($tableData);

    if (!$insert) {
      return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
    }
    return redirect()->back()->with('msg', 'Inserted Successfully!');;
  }

  public function show(Request $request)
  {
    $data['title'] = "View Stock Out";
    $data['allPdt'] = DB::table('products')->orderBy("title", "asc")->get();
    $data['bank'] = DB::table('banks')
      ->select('*')
      ->where("id", ">", 1)
      ->get();

    $search = $request->get("search");
    $pdtid = $request->get("pdtid");
    $sdate = $request->get("sdate");
    $edate = $request->get("edate");

    if ($search) {
      $rel = "";
      $query = DB::table('stock_out')
        ->join('products', 'stock_out.productsid', '=', 'products.id')
        ->select(
          'stock_out.*',
          'products.title'
        );
      if ($pdtid) {
        $query->where("products.id", $pdtid);
      }
      if ($sdate && $edate) {
        $query->where("stock_out.created_at", ">=", $sdate);
        $query->where("stock_out.created_at", "<=", $edate);
      } else if ($sdate) {
        $query->where("stock_out.created_at", ">=", $sdate);
        $query->where("stock_out.created_at", "<=", $sdate);
      } else if ($edate) {
        $query->where("stock_out.created_at", ">=", $edate);
        $query->where("stock_out.created_at", "<=", $edate);
      }
      $data['stockout'] = $query->orderBy("products.created_at", "desc")->paginate(30);
    } else {
      $data['stockout'] = DB::table('stock_out')
        ->join('products', 'stock_out.productsid', '=', 'products.id')
        ->select(
          'stock_out.*',
          'products.title'
        )
        ->orderBy("stock_out.created_at", "DESC")
        ->paginate(30);
    }
    return view('stockout.view', $data);
  }

  public function edit($id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['id'] = $id;
    $data['selected'] = DB::table('stock_out')
      ->where('id', "=", $id)
      ->first();
    $data['pdtname'] = DB::table('products')
      ->orderBy("title", "asc")
      ->get();
    $data['title'] = "Update Addi.Product";
    return view('stockout.edit', $data);
  }

  public function update(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $validationRules =
      [
        'stock' => 'required',
        'date' => 'required',
      ];

    $customMessage = [
      'stock.required' => 'Stock is required.',
      'date.required' => 'Created Date is required.',
    ];

    $tableData = [
      'productsid' => $request->input('product'),
      'stock' => $request->input('stock'),
      'challan' => $request->input('challan'),
      'description' => $request->input('description'),
      'created_at' => $request->input('date')
    ];
    $validateFormData = request()->validate($validationRules, $customMessage);

    $update = DB::table('stock_out')
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
    $delete[] = DB::table('stock_out')
      ->where("id", "=", "$id")
      ->delete();

    if (!$delete) {
      return redirect()->back()->with('error', 'Not Deleted!!');
    }
    return redirect()->route('stockout.view')->with('msg', 'Deleted Successfully!');
  }
}
