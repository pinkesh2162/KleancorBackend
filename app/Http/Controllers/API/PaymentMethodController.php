<?php

namespace App\Http\Controllers\API;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends BaseController
{
    public function index($id)
    {
        $data = DB::table("payment_methods")
        ->select('*')
        ->where('user_id', $id)
        ->first();
        return response()->json($data);
    }

 
    
  public function update(Request $request)
    {
        $isPaymentInfo = PaymentMethod::where('user_id', $request->userId)->first();
        if($isPaymentInfo == null) {
            $paymentInfo=new PaymentMethod;
            $paymentInfo->user_id=$request->userId;
            $paymentInfo->payment_type=$request->paymentType;
            $paymentInfo->paypal_email=$request->paypalEmail;
            $paymentInfo->first_name=$request->firstName;
            $paymentInfo->last_name=$request->lastName;
            $paymentInfo->address_line_1=$request->addressLine1;
            $paymentInfo->city=$request->cityName;
            $paymentInfo->phone=$request->phone;
            $paymentInfo->state=$request->stateName;
            $paymentInfo->zip=$request->zipCode;
            $paymentInfo->bank_name=$request->bankName;
            $paymentInfo->account_number=$request->accountNumber;
            $paymentInfo->routing_number=$request->routingNumber;
            // $paymentInfo->card_type=$data->cardType;
            $paymentInfo->card_number=$request->cardNumber;
            $paymentInfo->exp_month=$request->expMonth;
            $paymentInfo->exp_year=$request->expYear;
            $paymentInfo->cvv=$request->cvvNumber;
            $paymentInfo->save();
            
        }else{
         $paymentInfo = PaymentMethod::where('user_id', $request->userId)
                    ->update([
                'payment_type'=>$request->paymentType,
                'paypal_email'=>$request->paypalEmail,
                'first_name'=>$request->firstName,
                'last_name'=>$request->lastName,
                'address_line_1'=>$request->addressLine1,
                // 'address_line_2'=>$request->addressLine2,
                'city'=>$request->cityName,
                'phone'=>$request->phone,
                'state'=>$request->stateName,
                'zip'=>$request->zipCode,
                'bank_name'=>$request->bankName,
                'account_number'=>$request->accountNumber,
                'routing_number'=>$request->routingNumber,
                // 'card_type'=>$request->cardType,
                'card_number'=>$request->cardNumber,
                'exp_month'=>$request->expMonth,
                'exp_year'=>$request->expYear,
                'cvv'=>$request->cvvNumber,
                    ]);
        }
        
        

            if($paymentInfo){
                return response([
                    'message'=>'Your payment Updated Successfully'
                    ],200); 
            }else{
                return response([
                    'message'=>'Your payment Updated failed !'
                    ],400);
            }  

        } 

}
