<?php

namespace App\Http\Controllers\API;

use App\Models\Card;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Mockery\Exception;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Transfer;

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
        if ($isPaymentInfo == null) {
            $paymentInfo = new PaymentMethod;
            $paymentInfo->user_id = $request->userId;
            $paymentInfo->payment_type = $request->paymentType;
            $paymentInfo->paypal_email = $request->paypalEmail;
            $paymentInfo->first_name = $request->firstName;
            $paymentInfo->last_name = $request->lastName;
            $paymentInfo->address_line_1 = $request->addressLine1;
            $paymentInfo->city = $request->cityName;
            $paymentInfo->phone = $request->phone;
            $paymentInfo->state = $request->stateName;
            $paymentInfo->zip = $request->zipCode;
            $paymentInfo->bank_name = $request->bankName;
            $paymentInfo->account_number = $request->accountNumber;
            $paymentInfo->routing_number = $request->routingNumber;
            // $paymentInfo->card_type=$data->cardType;
            $paymentInfo->card_number = $request->cardNumber;
            $paymentInfo->exp_month = $request->expMonth;
            $paymentInfo->exp_year = $request->expYear;
            $paymentInfo->cvv = $request->cvvNumber;
            $paymentInfo->save();
        } else {
            $paymentInfo = PaymentMethod::where('user_id', $request->userId)
                ->update([
                    'payment_type' => $request->paymentType,
                    'paypal_email' => $request->paypalEmail,
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'address_line_1' => $request->addressLine1,
                    // 'address_line_2'=>$request->addressLine2,
                    'city' => $request->cityName,
                    'phone' => $request->phone,
                    'state' => $request->stateName,
                    'zip' => $request->zipCode,
                    'bank_name' => $request->bankName,
                    'account_number' => $request->accountNumber,
                    'routing_number' => $request->routingNumber,
                    // 'card_type'=>$request->cardType,
                    'card_number' => $request->cardNumber,
                    'exp_month' => $request->expMonth,
                    'exp_year' => $request->expYear,
                    'cvv' => $request->cvvNumber,
                ]);
        }



        if ($paymentInfo) {
            return response([
                'message' => 'Your payment Updated Successfully'
            ], 200);
        } else {
            return response([
                'message' => 'Your payment Updated failed !'
            ], 400);
        }
    }

    // __new __kishan __start
    public function createPaymentUser(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['error' => 'User not found'], 404);
        }
        Stripe::setApiKey(config('app.stripe_secret'));

        //create customer if not exist
        if (empty($user->payment_customer_id)) {
            // Create a new customer in Stripe
            $customer = \Stripe\Customer::create([
                'email' => $user->email,
                'name'  =>  $user->first_name . ' ' . $user->last_name,
            ]);
            $user->payment_customer_id = $customer->id;
            $user->save();
        }

        //create card token 
        $token = $this->createStripeToken($request->card);
        Stripe::setApiKey(config('app.stripe_secret'));
        $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'token' => $token->id,
            ],
            'billing_details' => [
                'email'  => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
            ],
        ]);
        $paymentMethod->attach(['customer' => $user->payment_customer_id]);
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'usd',
                'customer' => $user->payment_customer_id,
                'payment_method' => $paymentMethod->id,
                'off_session' => true,
                'confirm' => true,
                'description' => 'Payment for exported goods',
                'shipping' => [
                    'name' => $user->first_name,
                    'address' => [
                        'line1' => '123 Main Street',
                        'line2' => '123 Main Street',
                        'city' => 'New York',
                        'state' => 'NY',
                        'postal_code' => '10001',
                        'country' => 'US',
                    ],
                ],
                //                'metadata' => [
                //                    'discount' => $discount,
                //                ],
            ]);
            return response()->json($paymentIntent);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createStripeToken($cardInput)
    {
        Stripe::setApiKey(config('app.stripe_public'));
        return \Stripe\Token::create(['card' => $cardInput]);
    }

    //verify payment from admin
    public function verifyPayment(Request $request, $paymentId)
    {
        $payment = \DB::table('payments')->where('id', $paymentId)->first();

        if (!$payment || $payment->status !== 'pending') {
            return response()->json(['error' => 'Payment not found or already verified'], 404);
        }

        \DB::table('payments')->where('id', $paymentId)->update(['status' => 'verified']);

        return response()->json(['message' => 'Payment verified successfully']);
    }

    //for delete account
    public function deleteStripeAccount($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        if (empty($user->payment_customer_id)) {
            return response()->json(['error' => 'User not have stripe account.'], 404);
        }
        Stripe::setApiKey(config('app.stripe_secret'));

        if ($user->stripe_bank_id) {
            $bank = \Stripe\Account::retrieveExternalAccount($user->payment_customer_id, $user->stripe_bank_id);
            $bank->delete();
        }

        $account = \Stripe\Account::retrieve($user->payment_customer_id);
        $account->delete();
        $user->update(['payment_customer_id' => null, 'stripe_bank_id' => null]);
        return response()->json(['message' => 'account deleted successfully']);
    }
    //for create account
    public function createStripeAccount(Request $request, $id)
    {
        Stripe::setApiKey(config('app.stripe_secret'));
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        if (! empty($user->payment_customer_id)) {
            return response()->json(['error' => 'Already created account.'], 404);
        }

        try {
            $account = \Stripe\Account::create([
                'type' => 'custom',
                'country' => $request->country,
                'email' => $user->email,
                'business_type' => 'individual',
                'individual' => [
                    'address' => [
                        'line1' => $request->address,
                        'postal_code' => $request->postal_code,
                        'state' => $request->state,
                        'city' => $request->city,
                    ],
                    'dob' => [
                        'day' => $request->dob['day'],
                        'month' => $request->dob['month'],
                        'year' => $request->dob['year'],
                    ],
                    'email' => $user->email,
                    'phone' => $request->phone,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'maiden_name' => $user->first_name . ' ' . $user->last_name,
                    'id_number' => '000000000',
                ],
                'business_profile' => [
                    'mcc' => '4215',
                    'product_description' => 'Business service',
                    'support_email' => 'rahul@gmail.com',
                    'support_phone' => '+14155552672',
                    'url' => 'https://accessible.stripe.com',
                ],
                'tos_acceptance' => [
                    'date' => time(),
                    'ip' => $request->ip(),
                ],
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            $user->update(['payment_customer_id' => $account->id]);

            return response()->json(['message' => 'account created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //for link bank account
    public function linkBankAccount(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        if (empty($user->payment_customer_id)) {
            return response()->json(['error' => 'Stripe Account not found.'], 404);
        }

        if (! empty($user->stripe_bank_id)) {
            return response()->json(['error' => 'Already have bank account not found.'], 404);
        }

        Stripe::setApiKey(config('app.stripe_secret'));

        // Create a bank account token
        $token = \Stripe\Token::create([
            'bank_account' => [
                'country'             => $request->country,
                'currency'            => $request->currency,
                'account_holder_name' => $user->first_name . ' ' . $user->last_name,
                'account_holder_type' => 'individual',
                'routing_number'      => '110000000',
                'account_number'      => $request->bank_number,
            ],
        ]);

        $externalAccount = \Stripe\Account::createExternalAccount(
            $user->payment_customer_id,
            ['external_account' => $token->id,]
        );

        $user->update(['stripe_bank_id' => $externalAccount->id]);

        return response()->json(['message' => 'Bank account link successfully.'], 200);
    }

    //    create transfer account
    public function createTransfer(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        if (empty($user->payment_customer_id)) {
            return response()->json(['error' => 'Stripe Account not found.'], 404);
        }

        Stripe::setApiKey(config('app.stripe_secret'));

        try {
            $transfer = Transfer::create([
                'amount' => $request->amount * 100,
                'currency' => $request->currency,
                'destination' => $user->payment_customer_id,
                'transfer_group' => 'ADMIN_PAYMENT',
            ]);

            return response()->json($transfer, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //transfer money to bank account 
    public function transferToBankAccount(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        if (empty($user->payment_customer_id)) {
            return response()->json(['error' => 'Stripe Account not found.'], 404);
        }

        if (empty($user->stripe_bank_id)) {
            return response()->json(['error' => 'Stripe bank Account not found.'], 404);
        }

        Stripe::setApiKey(config('app.stripe_secret'));

        try {
            $payout = \Stripe\Payout::create(
                [
                    'amount'      => round($request->amount * 100),
                    'currency'    => $request->currency,
                    'destination' => $user->stripe_bank_id,
                    'description' => 'Payout to external bank account',
                ],
                [
                    'stripe_account' => $user->payment_customer_id,
                ]
            );

            // Return the payout details
            return response()->json(['payout' => $payout], 200);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
    // __end __kishan __start
}
