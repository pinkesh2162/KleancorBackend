<?php

namespace App\Http\Controllers\DalyExpense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DalyexpenseController extends Controller
{
    public function index()
    {
        $data['title'] = "Insert Daly Expense";

        $data['project'] = DB::table('projects')
        ->select('*')
        ->get();
        $data['bank'] = DB::table('banks')
        ->select('*')
        ->get();
        return view('admincontrol.dalyExpense.create-daly-expense',$data);
    }
     

    public function create(Request $request)
    {
                $validationRules =
                [
                'title' => 'required|100',
                'description' => 'required|156',
                'date' => 'required',
                    /*
                'amount' => 'required',
                'payment_method' => 'required|numeric|min:1',  
                */
            ];

            $customMessage = [
                'title.required' => 'Title  is required.',
                'description.required' => 'Description is required.',
                'date.required' => 'Created Date is required.',
                /*
                'amount.numeric|min:1' => 'Amount is required.',
                'amount.required|numeric' => 'Amount is must be number.',
                'payment_method.required|numeric' => 'Payment Method is required.',
                'payment_method.required|numeric|min:1' => 'Payment Method is must be number.',
                */
            ];

            $tableData = [
                'projectid' => $request->input('project_name'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                //'amount'    => $request->input('amount'),
                //'payment_method'    => $request->input('payment_method'),
                'date'      => $request->input('date'),  
                'usersid'    =>Auth::user()->id,
                'verified' => 0,
                'created_at' => date('Y-m-d'),
            ];

        if($request->input('payment_method') == 1){
            $validationRules['payment_method'] = 'required|numeric';
            $customMessage['payment_method.required'] = 'Payment Method field must be fill';
            $validationRules['amount'] = 'required|numeric';
            $customMessage['amount.required'] = 'Amount field must be fill';
            $tableData['cash'] = $request->input('amount');
            $tableData['amount'] = $request->input('amount');
            $tableData['payment_method'] = $request->input('payment_method');
        }
        if($request->input('payment_method') == 2){
            $validationRules['payment_method'] = 'required|numeric';
            $customMessage['payment_method.required'] = 'Payment Method field must be fill';
            $validationRules['amount'] = 'required|numeric';
            $customMessage['amount.required'] = 'Amount field must be fill';
            $validationRules['only_cheque_bank_name'] = 'required|numeric';
            $customMessage['only_cheque_bank_name.required'] = 'Bank Name field must be fill';
            $tableData['amount'] = $request->input('amount');
            $tableData['bank_id'] = $request->input('only_cheque_bank_name');
            $tableData['bank_amount'] = $request->input('amount');
            $tableData['payment_method'] = $request->input('payment_method');
        }
        if($request->input('payment_method') == 3){
            $validationRules['payment_method'] = 'required|numeric';
            $customMessage['payment_method.required'] = 'Payment Method field must be fill';
            $validationRules['amount'] = 'required|numeric';
            $customMessage['amount.required'] = 'Amount field must be fill';
            $validationRules['cash_amount'] = 'required|numeric';
            $customMessage['cash_amount.required'] = 'Cash Amount  field must be fill';
            $validationRules['both_cheque_bank_name'] = 'required|numeric';
            $customMessage['both_cheque_bank_name.required'] = 'Bank Name field must be fill';
            $validationRules['both_cheque_amount'] = 'required|numeric';
            $customMessage['both_cheque_amount.required'] = 'Cheque Amount  field must be fill';
            $customMessage['both_cheque_amount.required|numeric'] = 'Cheque Amount  field must be fill';
            $tableData['amount'] = $request->input('amount');
            $tableData['cash'] = $request->input('cash_amount');
            $tableData['bank_id'] = $request->input('both_cheque_bank_name');
            $tableData['bank_amount'] = $request->input('both_cheque_amount');
            $tableData['payment_method'] = $request->input('payment_method');
        }


            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $insert = DB::table('daily_expense')
                ->insert($tableData);

            if (!$insert) {
                return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
            }
            return redirect()->back()->with('msg', 'Inserted Successfully!');

    }


    public function view(Request $request)
    {   
        $data['title'] = "View Daly Expense";

        $sdate =   $request->get("sdate");
        $edate =   $request->get("edate");

        if($sdate == "" && $edate == "")
        {
            $data['project'] = DB::table('projects')
            ->select('*')
            ->get();
    
            $data['dalyExpense'] = DB::table('daily_expense')
            ->join('users','daily_expense.usersid','=','users.id')
            ->join('banks','daily_expense.bank_id','=','banks.id')
            ->select('daily_expense.*','users.name as uname','banks.name as bname')
            ->paginate(30);
            return view('admincontrol.dalyExpense.dalyexpense-view',$data);
        }
        else {
         $data['project'] = DB::table('projects')
            ->select('*')
            ->get();
    
            $query = DB::table('daily_expense')
            ->join('users','daily_expense.usersid','=','users.id')
            ->join('banks','daily_expense.bank_id','=','banks.id')
            ->select('daily_expense.*','users.name as uname','banks.name as bname');
           
            if($sdate && $edate) {
                $query->where("daily_expense.created_at", ">=",$sdate);          
                $query->where("daily_expense.created_at", "<=", $edate);          
            }    
            else if($sdate){
                $query->where("daily_expense.created_at", $sdate);      
            }  
            else if($edate){
                $query->where("daily_expense.created_at", $edate);      
            } 
            $data['dalyExpense'] = $query->get();
            $data['title'] = "Search Daly Expense";
            return view('admincontrol.dalyExpense.dalyexpense-view-search',$data);
        }
    }


    public function edit($id)
    {
        $data['title'] = "Update Daly Expense";
        $data['project'] = DB::table('projects')
        ->select('*')
        ->get();
        $data['bank'] = DB::table('banks')
        ->select('*')
        ->get();

        $data['dalyExpense'] = DB::table('daily_expense')
        ->where('id','=',"$id")
        ->first();
        /*
        if(Auth::user()->type == 1 && $data['user']->verified == 1){
            return redirect()->route('viewexpense');
        }
        */
        return view('admincontrol.dalyExpense.edit-daly-expense',$data);  
    }


    public function update(Request $request,$id)
    {
                $validationRules =
                [
                'title' => 'required',
                'description' => 'required',
                'date' => 'required',
                    /*
                'amount' => 'required',
                'payment_method' => 'required|numeric|min:1',  
                */
            ];

            $customMessage = [
                'title.required' => 'Title  is required.',
                'description.required' => 'Description is required.',
                'date.required' => 'Created Date is required.',
                /*
                'amount.numeric|min:1' => 'Amount is required.',
                'amount.required|numeric' => 'Amount is must be number.',
                'payment_method.required|numeric' => 'Payment Method is required.',
                'payment_method.required|numeric|min:1' => 'Payment Method is must be number.',
                */
            ];

            $tableData = [
                'projectid' => $request->input('project_name'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                //'amount'    => $request->input('amount'),
                //'payment_method'    => $request->input('payment_method'),
                'date'      => $request->input('date'), 
                'usersid'    =>Auth::user()->id,
                'verified' => 0,
                'updated_at' => date('Y-m-d'),
            ];

        if($request->input('payment_method') == 1){
            $validationRules['payment_method'] = 'required|numeric';
            $customMessage['payment_method.required'] = 'Payment Method field must be fill';
            $validationRules['amount'] = 'required|numeric';
            $customMessage['amount.required'] = 'Amount field must be fill';
            $tableData['cash'] = $request->input('amount');
            $tableData['amount'] = $request->input('amount');
            $tableData['payment_method'] = $request->input('payment_method');
        }
        if($request->input('payment_method') == 2){
            $validationRules['payment_method'] = 'required|numeric';
            $customMessage['payment_method.required'] = 'Payment Method field must be fill';
            $validationRules['amount'] = 'required|numeric';
            $customMessage['amount.required'] = 'Amount field must be fill';
            $validationRules['only_cheque_bank_name'] = 'required|numeric';
            $customMessage['only_cheque_bank_name.required'] = 'Bank Name field must be fill';
            $tableData['amount'] = $request->input('amount');
            $tableData['bank_id'] = $request->input('only_cheque_bank_name');
            $tableData['bank_amount'] = $request->input('amount');
            $tableData['payment_method'] = $request->input('payment_method');
        }
        if($request->input('payment_method') == 3){
            $validationRules['payment_method'] = 'required|numeric';
            $customMessage['payment_method.required'] = 'Payment Method field must be fill';
            $validationRules['amount'] = 'required|numeric';
            $customMessage['amount.required'] = 'Amount field must be fill';
            $validationRules['cash_amount'] = 'required|numeric';
            $customMessage['cash_amount.required'] = 'Cash Amount  field must be fill';
            $validationRules['both_cheque_bank_name'] = 'required|numeric';
            $customMessage['both_cheque_bank_name.required'] = 'Bank Name field must be fill';
            $validationRules['both_cheque_amount'] = 'required|numeric';
            $customMessage['both_cheque_amount.required'] = 'Cheque Amount  field must be fill';
            $customMessage['both_cheque_amount.required|numeric'] = 'Cheque Amount  field must be fill';
            $tableData['amount'] = $request->input('amount');
            $tableData['cash'] = $request->input('cash_amount');
            $tableData['bank_id'] = $request->input('both_cheque_bank_name');
            $tableData['bank_amount'] = $request->input('both_cheque_amount');
            $tableData['payment_method'] = $request->input('payment_method');
        }


            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $update = DB::table('daily_expense')
                ->where('id','=',"$id")
                ->update($tableData);

            if (!$update) {
                return redirect()->back()->with('error', 'Invalid information, Not Update!!');
            }
            return redirect()->route('viewexpense')->with('msg', 'Update Successfully!');
    }


    public function delete($id)
    {
         /*
        if(Auth::user()->type == 1 && $data['user']->verified == 1){
            return redirect()->route('viewexpense');
        }
        */

        $delete = DB::table('daily_expense')
        ->where('id','=',"$id")
        ->delete();
        if(!$delete){
           return redirect()->back()->with('error','Not Deleted!');
        }
        return redirect()->back()->with('msg','Deleted Successfully!');
    }

}
