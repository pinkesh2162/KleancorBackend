<?php

namespace App\Http\Controllers\Units;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UnitsController extends Controller
{
    public function index(){
        return view('admincontrol.units.create-unit');
    }

    public function create(Request $request)
    {
    
         $validationRules =
            [
                'unit' => 'required|max:255',
                'date' => 'required',
            ];

            $customMessage = [
                'unit.required' => 'Unit Name is required.',
                'date.required' => 'Created Date is required.',
            ];

            $tableData = [
                'name' => $request->input('unit'),
                'status' => 1,
               'created_at' => $request->input('date'),
           ];

           $validateFormData = request()->validate($validationRules, $customMessage);

           if (!$validateFormData) {
            return redirect()->back()->withErrors($request->all());
        }
 
        $insert = DB::table('units')
            ->insert($tableData);
 
        if (!$insert) {
            return redirect()->back()->with('msg', 'Invalid information, Not Inserted!!');
        }
        return redirect()->back()->with('error', 'Inserted Successfully!!');
    }

    public function view(Request $request)
    {

        $data['units'] = DB::table('units')
            ->select('*')
            ->paginate(10);
        return view('admincontrol.units.view-unit', $data);

    }


    public function edit($id)
    {

        $data['units'] = DB::table('units')
            ->where('id', "=", $id)
            ->first();
        return view('admincontrol.units.edit-unit', $data);
    }

    public function update(Request $request, $id)
    {
        
        
        $validationRules =
            [
                'unit' => 'required',
                'date' => 'required',
            ];

            $customMessage = [
                'unit.required' => 'Unit Name is required.',
                'date.required' => 'Created Date is required.',
            ];

            $tableData = [
                'name' => $request->input('unit'),
                'status' => 1,
               'created_at' => $request->input('date'),
           ];

        $validateFormData = request()->validate($validationRules, $customMessage);

        if (!$validateFormData) {
            return redirect()->back()->withErrors($request->all());
        }

        $update = DB::table('units')
            ->where('id', $id)
            ->update($tableData);

        if (!$update) {
            return redirect()->back()->with('error', 'Information Not Updated!!');
        }
        return redirect()->back()->with('msg', 'Information is Updated Successfully!!!');
        //return redirect()->route('allusers')->with('msg', 'Information is Updated Successfully!');
    }

    public function delete($id)
    {
        
        $delete = DB::table('units')
            ->where("id", "=", "$id")
            ->delete();

        if (!$delete) {
            return redirect()->back()->with('error', 'Not Deleted!!');
        }

        return redirect()->route('allunits')->with('msg', 'Deleted Successfully!');

    }
}
