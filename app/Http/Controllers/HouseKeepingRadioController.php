<?php

namespace App\Http\Controllers;

use App\Models\HouseKeepingRadio;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseKeepingRadioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $housekeepingradios = DB::table('house_keeping_radios')
        ->join('categories', 'categories.id', '=', 'house_keeping_radios.category_id')
        ->select('house_keeping_radios.*', 'categories.name as cname')
        ->get();
        return view('housekeepingradios.index', compact('housekeepingradios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
        return view('housekeepingradios.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $labelList = $request->input('label');
        $valueList = $request->input('value');

        $combined = [];
        for($i = 0; $i < count($labelList); $i++){
            $combined[] = ['label'=>$labelList[$i], 'value'=>$valueList[$i]];
        }

        $list = [
            'posting_title' => $request->input('posting_title'),
            'display_title' => $request->input('display_title'),
            'category_id' => $request->input('category_id'),
            'label_list' => json_encode($combined),
            'status' => $request->input('status')
        ];
        DB::table('house_keeping_radios')->insert($list);
        return redirect()->route('housekeepingradios.index')->with('message', 'HouseKeeping Radio Added Successfully!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data['categories'] = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $data['list'] = DB::table('house_keeping_radios')
        ->select('house_keeping_radios.*', 'categories.name as cname')
        ->join('categories', 'categories.id', '=', 'house_keeping_radios.category_id')     
        ->where('house_keeping_radios.id', $id)
        ->first();
        // die();
        return view('housekeepingradios.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $labelList = $request->input('label');
        $valueList = $request->input('value');

        $combined = [];
        for($i = 0; $i < count($labelList); $i++){
            $combined[] = ['label'=>$labelList[$i], 'value'=>$valueList[$i]];
        }

        $list = [
            'posting_title' => $request->post('posting_title'),
            'display_title' => $request->post('display_title'),
            'category_id' => $request->post('category_id'),
            'label_list' => json_encode($combined),
            'status' => $request->post('status')
        ];

        DB::table('house_keeping_radios')
        ->where('house_keeping_radios.id', $id)
        ->update($list);

        return redirect()->route('housekeepingradios.index')->with('message', 'HouseKeepingRadio Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HouseKeeping  $houseKeeping
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseKeepingRadio $housekeepingradio)
    {
        $housekeepingradio->delete();
        return redirect()->route('housekeepingradios.index')->with('error', 'HouseKeepingRadio Delete Successfully!!');
    }
}
