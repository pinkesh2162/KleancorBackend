<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\OurPayment;

class PaymentController extends Controller
{
    public function index()
    {
        echo Auth::user()->id;
         //die();
        $data['sales'] = DB::table('sales')
            ->select('*')
            ->get();

        return view('admincontrol.payments.insert-payment', $data);
    }

    public function create(Request $request)
    {

        $validationRules =
            [
            'salesid' => 'required',
            'pmethod' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ];

        $customMessage = [
            'salesid.required' => 'Sales ID is required.',
            'pmethod.required' => 'Payment is required.',
            'amount.required' => 'Amount is required.',
            'date.required' => 'Amount is required.',
        ];

        $tableData = [
            'salesid' => $request->get('salesid'),
            'payment_method' => $request->input('pmethod'),
            'userid' => Auth::user()->id,
            'amount' => $request->input('amount'),
            'created_at' => $request->input('date'),
            'verified' => 1,
            'status' => 1,
        ];

        $validateFormData = request()->validate($validationRules, $customMessage);


        $insert = DB::table('payments')
            ->insert($tableData);

        if (!$insert) {
            return redirect()->back()->with('msg', 'Invalid information, Not Inserted!!');
        }
        return redirect()->back()->with('error', 'Inserted Successfully!!');
    }

    public function view(Request $request)
    {

        $data['paymentinfo'] = DB::table('payments')
            ->join('users', 'payments.userid', '=', 'users.id')
            ->select('payments.*', 'users.name')            
            ->paginate(10);
        return view('admincontrol.payments.viewpayment', $data);

    }

    public function edit($id)
    {
        $data['id'] = $id;
        $data['sales'] = DB::table('sales')
            ->select('*')
            ->get();

        $data['paymentinfo'] = DB::table('payments')                                 
                 ->select('payments.*')
                 ->where('id', "=", $id)
                 ->first();
        $data['userid'] = DB::table('users')
        ->select('*')
        ->get();
    return view('admincontrol.payments.edit-payment', $data);
    }

    public function update(Request $request, $id)
    {
  
        
        $validationRules =
            [
                'salesid' => 'required',
                'pmethod' => 'required',
                'amount' => 'required',
                'date' => 'required',
            
        ];

        $customMessage = [
            'salesid.required' => 'Sales ID is required.',
            'pmethod.required' => 'Payment is required.',
            'amount.required' => 'Amount is required.',
            'date.required' => 'Amount is required.',
            
        ];

        $tableData = [
            
            'salesid' => $request->get('salesid'),
            'payment_method' => $request->input('pmethod'),
            'userid' => Auth::user()->id,
            'amount' => $request->input('amount'),
            'updated_at' => $request->input('date'),
            'verified' => 1,
            'status' => 1,
        
         
        ];

        $validateFormData = request()->validate($validationRules, $customMessage);

        if (!$validateFormData) {
            return redirect()->back()->withErrors($request->all());
        }

        $update = DB::table('payments')
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
        $delete = DB::table('payments')
            ->where("id", "=", "$id")
            ->delete();

        if (!$delete) {
            return redirect()->back()->with('error', 'Not Deleted!!');
        }

        return redirect()->route('paymentview
        ')->with('msg', 'Deleted Successfully!');

    }
}
