<?php

namespace App\Http\Controllers\BankDeposit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;

class BankDepositController extends Controller
{
    public function index(){
        $data['bank'] = DB::table('banks')
        ->select('*')
        ->get();
        $data['title'] = "Create Bank Acc" ;
        return view('admincontrol.bankdeposit.create-bank-deposit',$data);
    }

    public function insert(Request $request)
    {
            $validationRules =
            [
            'name' => 'required',
            'amount' => 'required',
            'date' => 'required',

        ];

        $customMessage = [
            'name.required' => 'Bank Name is required.',
            'amount.required' => 'Amount is required.',
            'date.required' => 'Deposit Date is required.',

        ];

        $tableData = [
            'bankid' =>$request->input('name'),
            'amount' => $request->input('amount'),
            'date'      => date('Y-m-d'),
            'usersid' => Auth::user()->id,
            'verified' => 0,
            'created_at' => $request->input('date'),
            ];

            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $insert = DB::table('bank_deposits')
                ->insert($tableData);

            if (!$insert) {
                return redirect()->back()->with('error', 'Invalid information, Not Inserted!!');
            }
            return redirect()->back()->with('msg', 'Inserted Successfully!');

    }

    public function view(Request $request)
    {
            $sdate =   $request->get("sdate");
            $edate =   $request->get("edate");

            if($sdate == "" && $edate == "")
            {
                $data['bankdeposit'] = DB::table('bank_deposits')
                ->join('banks', 'bank_deposits.bankid', '=', 'banks.id')
                ->join('users', 'bank_deposits.usersid', '=', 'users.id')
                ->select('bank_deposits.*','banks.id as bankid','banks.name as bankname','users.name as uname')
                ->where('bank_deposits.status','=',1)
                ->paginate(30);
                $data['title'] = "Active Bank Acc" ;
                return view('admincontrol.bankdeposit.view-bank-deposit',$data);
            }
            else{
            $query = DB::table('bank_deposits')
            ->join('banks', 'bank_deposits.bankid', '=', 'banks.id')
            ->join('users', 'bank_deposits.usersid', '=', 'users.id')
            ->select('bank_deposits.*','banks.id as bankid','banks.name as bankname','users.name as uname')
            ->where('bank_deposits.status','=',1);

            if($sdate && $edate) {
                $query->where("bank_deposits.created_at", ">=",$sdate);
                $query->where("bank_deposits.created_at", "<=", $edate);
            }
            else if($sdate){
                $query->where("bank_deposits.created_at", $sdate);
            }
            else if($edate){
                $query->where("bank_deposits.created_at", $edate);
            }

            $data['bankdeposit'] = $query->get();
            $data['title'] = "Search Result Bank Acc" ;
            return view('admincontrol.bankdeposit.search-view-bank-deposit',$data);
        }
    }

    public function allfrozen(Request $request)
    {

            $sdate =   $request->get("sdate");
            $edate =   $request->get("edate");

            if($sdate == "" && $edate == "")
                {
                    $data['bankdeposit'] = DB::table('bank_deposits')
                    ->join('banks', 'bank_deposits.bankid', '=', 'banks.id')
                    ->join('users', 'bank_deposits.usersid', '=', 'users.id')
                    ->select('bank_deposits.*','banks.id as bankid','banks.name as bankname','users.name as uname')
                    ->where('bank_deposits.status','=',0)
                    ->paginate(30);
                    $data['title'] = "All Frozen Bank Acc" ;
                    return view('admincontrol.bankdeposit.frozen-bank-deposit',$data);
                }
                else{
                $query = DB::table('bank_deposits')
                ->join('banks', 'bank_deposits.bankid', '=', 'banks.id')
                ->join('users', 'bank_deposits.usersid', '=', 'users.id')
                ->select('bank_deposits.*','banks.id as bankid','banks.name as bankname','users.name as uname')
                ->where('bank_deposits.status','=',0);

                if($sdate && $edate) {
                    $query->where("bank_deposits.created_at", ">=",$sdate);
                    $query->where("bank_deposits.created_at", "<=", $edate);
                }
                else if($sdate){
                    $query->where("bank_deposits.created_at", $sdate);
                }
                else if($edate){
                    $query->where("bank_deposits.created_at", $date);
                }

                $data['bankdeposit'] = $query->get();
                $data['title'] = "Search Result Frozen Bank Acc" ;
            return view('admincontrol.bankdeposit.search-view-bank-deposit',$data);
        }
    }

    public function edit($id)
    {

        $data['bank'] = DB::table('banks')
        ->select('*')
        ->get();

        $data['bankdeposit'] =   DB::table('bank_deposits')
            ->select('*')
            ->where('id',"$id")
            ->first();


        return view('admincontrol.bankdeposit.edit-bank-deposit',$data);
    }

    public function update(Request $request,$id)
    {
            $validationRules =
            [
            'name' => 'required',
            'amount' => 'required',
            'date' => 'required',

        ];

        $customMessage = [
            'name.required' => 'Bank Name is required.',
            'amount.required' => 'Amount is required.',
            'date.required' => 'Deposit Date is required.',

        ];

        $tableData = [
            'bankid' =>$request->input('name'),
            'amount' => $request->input('amount'),
            'date'      => date('Y-m-d'),
            'usersid' => Auth::user()->id,
            'verified' => 0,
            'status' =>1,
            'updated_at' => $request->input('date'),
            ];

            $validateFormData = request()->validate($validationRules, $customMessage);

            if (!$validateFormData) {
                return redirect()->back()->withErrors($request->all());
            }

            $update = DB::table('bank_deposits')
                ->where('id','=',"$id")
                ->update($tableData);

            if (!$update) {
                return redirect()->back()->with('error', 'Invalid information, Not Update!!');
            }
            return redirect()->route('viewbankdeposit')->with('msg', 'Update Successfully!');
    }

    public function frozen($id)
    {

        $tableData = [
            'status' => 0
        ];
        $update = DB::table('bank_deposits')
        ->where('id','=',"$id")
        ->update($tableData);

    if (!$update) {
        return redirect()->back()->with('error', 'Invalid information, Not Frozen!!');
    }
    return redirect()->back()->with('msg', 'Frozen Successfully!');

    }
    public function unfrozen($id)
    {

        $tableData = [
            'status' => 1
        ];
        $update = DB::table('bank_deposits')
        ->where('id','=',"$id")
        ->update($tableData);

    if (!$update) {
        return redirect()->back()->with('error', 'Invalid information, Not Active!!');
    }
    return redirect()->back()->with('msg', 'Active Successfully!');
    }

    public function delete($id)
    {
        /*
        $data['prjctedit'] = DB::table('projects')
        ->where('id','=',$id)
        ->first();
        if(Auth::user()->type == 1 && $data['prjctedit']->verified == 1){
            return redirect()->route('viewprojects');
        } */

        $delete = DB::table('bank_deposits')
        ->where('id','=',"$id")
        ->delete();
        if(!$delete){
           return redirect()->back()->with('error','Not Deleted!');
        }
        return redirect()->route('viewbankdeposit')->with('msg','Deleted Successfully!');

    }

}
