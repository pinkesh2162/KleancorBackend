<?php

namespace App\Http\Controllers\PersonalExpenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PersonalexpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type != 2) {
            return redirect()->route('dashboard');
        }
        $data['title'] = "Insert Personal Expense";
        return view("admincontrol.personalexpenses.create", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Auth::user()->type != 2) {
            return redirect()->route('dashboard');
        }
        $validationRules =
            [
                'title' => 'required|max:255',
                'amount' => 'required|numeric|min:1',
                'date' => 'required',
                /*
                    'amount' => 'required',
                    'payment_method' => 'required|numeric|min:1',  
                    */
            ];

        $customMessage = [
            'title.required' => 'Title  is required.',
            'amount.required' => 'Amount is required.',
            'date' => 'Date is required',
        ];

        $tableData = [
            'title' => $request->input('title'),
            'amount'    => $request->input('amount'),
            'date'      => $request->input('date'),
            'created_at' => date('Y-m-d'),
        ];

        $validateFormData = request()->validate($validationRules, $customMessage);

        if (!$validateFormData) {
            return redirect()->back()->withErrors($request->all());
        }
        $insert = DB::table('personal_expense')
            ->insert($tableData);

        if (!$insert) {
            return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
        }
        return redirect()->back()->with('msg', 'Inserted Successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->type != 2) {
            return redirect()->route('dashboard');
        }
        $sdate =   $request->get("sdate");
        $edate =   $request->get("edate");

        if ($sdate == "" && $edate == "") {
            $data['dalyExpense'] = DB::table('personal_expense')
                ->select("*")
                ->paginate(30);

            $data['title'] = "View Personal Expenses";
            return view("admincontrol.personalexpenses.view", $data);
        } else {
            $query =  DB::table('personal_expense')
                ->select("*");

            if ($sdate && $edate) {
                $query->where("personal_expense.date", ">=", $sdate);
                $query->where("personal_expense.date", "<=", $edate);
            } else if ($sdate) {
                $query->where("personal_expense.date", $sdate);
            } else if ($edate) {
                $query->where("personal_expense.date", $edate);
            }
            $data['dalyExpense'] = $query->get();
            $data['title'] = "Search Personal Expense";
            return view("admincontrol.personalexpenses.search-view", $data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->type != 2) {
            return redirect()->route('dashboard');
        }
        $data['dalyExpense'] = DB::table('personal_expense')
            ->where('id', $id)
            ->first();

        $data['title'] = "Update Personal Expenses";
        return view("admincontrol.personalexpenses.update", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->type != 2) {
            return redirect()->route('dashboard');
        }
        $validationRules =
            [
                'title' => 'required|max:255',
                'amount' => 'required|numeric|min:1',
                'date'   => 'required'
            ];

        $customMessage = [
            'title.required' => 'Title  is required.',
            'amount.required' => 'Amount is required.',
            'date'   => 'Date is required'
        ];

        $tableData = [
            'title' => $request->input('title'),
            //'description' => $request->input('description'),
            'amount'    => $request->input('amount'),
            'date'      => $request->input('date'),
            'updated_at' => date('Y-m-d')
        ];

        $validateFormData = request()->validate($validationRules, $customMessage);

        if (!$validateFormData) {
            return redirect()->back()->withErrors($request->all());
        }

        $update = DB::table('personal_expense')
            ->where('id', $id)
            ->update($tableData);

        if (!$update) {
            return redirect()->back()->with('error', 'Information Not Updated!!');
        }
        return redirect()->route('viewexpenses')->with('msg', 'Information is Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->type != 2) {
            return redirect()->route('dashboard');
        }
        $delete = DB::table('personal_expense')
            ->where('id', $id)
            ->delete();
        if (!$delete) {
            redirect()->back()->with('error', 'Not Deleted');
        }
        return redirect()->route('viewexpenses')->with('msg', 'Information is Deleted Successfully!!!');
    }
}
