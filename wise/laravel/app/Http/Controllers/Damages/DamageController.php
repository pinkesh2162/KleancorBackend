<?php

namespace App\Http\Controllers\Damages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DamageController extends Controller
{
  public function index()
  {
    $data['title'] = "Insert Damage";
    $data['allProduct'] = DB::table("products")->orderBY("title", "asc")->get();
    return view('damage.index', $data);
  }
  public function create(Request $request)
  {
    $pdtid = $request->input("product");
    $ap = DB::table("addproducts as ap")
      ->select(
        "ap.id",
        "ap.stock as totalStock",
        "ap.productid",
        DB::raw("(select sum(sd.quantity1) from sales_details as sd where ap.productid={$pdtid} and sd.addproductsid = ap.id and sd.quantity2=0) as totalSale1"),
        DB::raw("(select sum(sd.quantity2) from sales_details as sd where ap.productid={$pdtid} and sd.addproductsid = ap.id) as totalSale2"),
        DB::raw("(select sum(damages.quantity) from damages where ap.productid={$pdtid} and damages.addproductid = ap.id) as totalDamages")
      )
      ->where("ap.productid", "=", $pdtid)
      ->orderBy("ap.created_at", "asc")
      ->get();

    $original_damage = $temp_qty = $request->input("quantity");
    $str = str_random(15);

    foreach ($ap as $a) {
      if ($a->totalStock == $a->totalSale1 + $a->totalSale2 + $a->totalDamages) {
        continue; //Sold Out
      } else if (($a->totalStock >= ($temp_qty + $a->totalSale1 + $a->totalSale2 + $a->totalDamages))  && $temp_qty > 0) {
        $sd = [
          "addproductid" => $a->id,
          "reason" => $request->input("reason"),
          "original_damage" => $original_damage,
          "quantity" => $temp_qty,
          "random_number" => $str,
          "created_at" => $request->input("date") . " " . date("H:i:s")
        ];
        $sdids = DB::table("damages")->insertGetId($sd); //Quote Completed
        break;
      } else {
        $hmm = $a->totalStock - $a->totalSale1 - $a->totalDamages;

        $sd = [
          "addproductid" => $a->id,
          "reason" => $request->input("reason"),
          "original_damage" => $original_damage,
          "quantity" => $hmm,
          "random_number" => $str,
          "created_at" => $request->input("date") . " " . date("H:i:s")
        ];
        $sdids = DB::table("damages")->insertGetId($sd);
        $temp_qty = $temp_qty - $hmm;
      }
    }
    return redirect()->back()->with('msg', 'Save Successfully');
  }
  public function show(Request $request)
  {
    $data['title'] = "View Damage";
    $data['allProduct'] = DB::table("products")
      ->select("products.title", "damages.*")
      ->join("addproducts", "addproducts.productid", "=", "products.id")
      ->join("damages", "addproducts.id", "=", "damages.addproductid")
      // ->groupBy("damages.random_number")
      ->orderBY("damages.created_at", "desc")->paginate();
    return view('damage.view', $data);
  }
  public function edit(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    $data['title'] = "Insert Damage";
    $data['allProduct'] = DB::table("products")->orderBY("title", "asc")->get();
    $data['selected'] = DB::table("products")
      ->select("products.id as pid", "damages.*")
      ->join("addproducts", "addproducts.productid", "=", "products.id")
      ->join("damages", "addproducts.id", "=", "damages.addproductid")
      ->where("damages.random_number", $id)
      ->first();
    return view('damage.edit', $data);
  }
  public function update(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("damages")->where("random_number", $id)->delete();
    $pdtid = $request->input("product");
    $ap = DB::table("addproducts as ap")
      ->select(
        "ap.id",
        "ap.stock as totalStock",
        "ap.productid",
        DB::raw("(select sum(sd.quantity1) from sales_details as sd where ap.productid={$pdtid} and sd.addproductsid = ap.id and sd.quantity2=0) as totalSale1"),
        DB::raw("(select sum(sd.quantity2) from sales_details as sd where ap.productid={$pdtid} and sd.addproductsid = ap.id) as totalSale2"),
        DB::raw("(select sum(damages.quantity) from damages where ap.productid={$pdtid} and damages.addproductid = ap.id) as totalDamages")
      )
      ->where("ap.productid", "=", $pdtid)
      ->orderBy("ap.created_at", "asc")
      ->get();

    $original_damage = $temp_qty = $request->input("quantity");
    $str = str_random(15);

    foreach ($ap as $a) {
      if ($a->totalStock == $a->totalSale1 + $a->totalSale2 + $a->totalDamages) {
        continue; //Sold Out
      } else if (($a->totalStock >= ($temp_qty + $a->totalSale1 + $a->totalSale2 + $a->totalDamages))  && $temp_qty > 0) {
        $sd = [
          "addproductid" => $a->id,
          "reason" => $request->input("reason"),
          "original_damage" => $original_damage,
          "quantity" => $temp_qty,
          "random_number" => $str,
          "created_at" => $request->input("date") . " " . date("H:i:s")
        ];
        $sdids = DB::table("damages")->insertGetId($sd); //Quote Completed
        break;
      } else {
        $hmm = $a->totalStock - $a->totalSale1 - $a->totalDamages;

        $sd = [
          "addproductid" => $a->id,
          "reason" => $request->input("reason"),
          "original_damage" => $original_damage,
          "quantity" => $hmm,
          "random_number" => $str,
          "created_at" => $request->input("date") . " " . date("H:i:s")
        ];
        $sdids = DB::table("damages")->insertGetId($sd);
        $temp_qty = $temp_qty - $hmm;
      }
    }
    return redirect()->route('damage.view')->with('msg', 'Save Successfully');
  }
  public function delete(Request $request, $id)
  {
    if (Auth::user()->type != 2) {
      return redirect()->route('dashboard');
    }
    DB::table("damages")->where("random_number", $id)->delete();
    return redirect()->back()->with('msg', 'Delete Successfully');
  }
}
