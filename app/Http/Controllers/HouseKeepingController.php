<?php

namespace App\Http\Controllers;

use App\Models\HouseKeeping;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseKeepingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $housekeepings = DB::table('house_keepings')
        ->join('categories', 'categories.id', '=', 'house_keepings.category_id')
        ->select('house_keepings.*', 'categories.name as cname')
        ->get();
        return view('housekeepings.index', compact('housekeepings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get(); 
        return view('housekeepings.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'min_val' => 'required',
            'max_val' => 'required',
            'category_id' => 'required',
            'status' => 'required'          
        ]);
        HouseKeeping::create($request->all());
        return redirect()->route('housekeepings.index')->with('message', 'HouseKeeping Added Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function show(HouseKeeping $houseKeeping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function edit(HouseKeeping $housekeeping)
    {
        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $list = DB::table('house_keepings')
        ->join('categories', 'categories.id', '=', 'house_keepings.category_id')
        ->select('house_keepings.*', 'categories.name as cname')
        ->get();
        // print_r($list);
        // die();
        return view('housekeepings.edit', compact('housekeeping', 'categories', 'list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HouseKeeping $housekeeping)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'min_val' => 'required',
            'max_val' => 'required',
            'category_id' => 'required',
            'status' => 'required'   
        ]);
  
        $housekeeping->update($request->all());
        return redirect()->route('housekeepings.index')->with('message', 'HouseKeeping Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseKeeping $housekeeping)
    {
        $housekeeping->delete();
        return redirect()->route('housekeepings.index')->with('error', 'HouseKeeping Delete Successfully!!');
    }
}
