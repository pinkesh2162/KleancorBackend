<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Location;
use App\Models\Skill;
use App\Models\PasswordReset;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Mail;
use Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $auth_type = $request->auth_type;
        if ($auth_type == 1) {
            if (User::where('email', '=', $request->email)->first()) {
                $user = User::where('email', '=', $request->email)->first();
                $user['token'] =  $user->createToken('MyApp')->plainTextToken;
                return $this->sendResponse($user, 'You already have an existing account.');
            } else {
                $refer_code = rand(10000, 99999);
                while (1) {
                    $code = DB::table('users')->select('refer_code')->where('refer_code', $refer_code)->first();
                    if ($code) $refer_code = rand(10000, 99999);
                    else break;
                }
                $input = $request->all();
                $input['refer_code'] = $refer_code;
                if ($request->referCode) {
                    $input['status'] = 0;
                    DB::table('users')->where('refer_code', $request->referCode)->update(['status' => 0]);
                }
                $user = User::create($input);
                $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                $success['id'] =  $user->id;
                $success['first_name'] =  $user->first_name;
                $success['last_name'] =  $user->last_name;
                $success['email'] =  $user->email;
                $success['address'] =  $user->address;
                $success['about'] =  $user->about;
                $success['price'] =  $user->price;
                $success['expertise_label'] =  $user->expertise_label;
                $success['contact'] =  $user->contact;
                $success['auth_type'] =  $user->auth_type;
                $success['refer_code'] =  $user->refer_code;
                $success['status'] = $user->status;
                $success['title'] = "Welcome Message";
                $success['name'] =  $success['first_name'];
                $success['body'] = "You have completed registration at KleanCor! Welcome to KleanCor!!";


                if ($request->referCode) {
                    $code = DB::table('users')->select('id')->where('refer_code', $request->referCode)->first();
                    if ($code) {
                        DB::table('referrals')->insert(['refer_id' => $user->id, 'referrer_id' => $code->id]);
                    }
                }
                try {
                    Mail::send('emails/new-user', ['user' => $user], function ($message) use ($user) {
                        $message->to($user['email'])->subject('Welcome to ' . config('app.name'));
                    });
                    Mail::send('emails/admin-new-user', ['user' => $user], function ($message) use ($user) {
                        $message->to(config('app.admin_email'))->subject('New user register to ' . config('app.name'));
                    });
                } catch (\Throwable $th) {
                    \Log::info($th);
                }

                return $this->sendResponse($success, 'User register successfully.');
            }
        } else {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'nullable',
                    "required_if:auth_type, ==, 0",
                    Rule::unique('users')->ignore($auth_type)
                ],
                'auth_type' => 'required|integer',
                'auth_id' =>  [
                    'nullable',
                    "required_if:auth_type, ==, 1"
                ],
                'password' => [
                    'nullable',
                    "required_if:auth_type, ==, 0"
                ],
                'c_password' =>  [
                    'nullable',
                    "required_if:auth_type, ==, 0|same:password"
                ],
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $input = $request->all();
            if ($request->password != '') {
                $input['password'] = bcrypt($input['password']);
            }
            $refer_code = rand(10000, 99999);
            while (1) {
                $code = DB::table('users')->select('refer_code')->where('refer_code', $refer_code)->first();
                if ($code) $refer_code = rand(10000, 99999);
                else break;
            }
            $input['refer_code'] = $refer_code;
            if ($request->referCode) {
                $input['status'] = 0;
                DB::table('users')->where('refer_code', $request->referCode)->update(['status' => 0]);
            }

            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['id'] =  $user->id;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] =  $user->last_name;
            $success['email'] =  $user->email;
            $success['address'] =  $user->address;
            $success['about'] =  $user->about;
            $success['price'] =  $user->price;
            $success['expertise_label'] =  $user->expertise_label;
            $success['contact'] =  $user->contact;
            $success['auth_type'] =  $user->auth_type;
            $success['refer_code'] =  $user->refer_code;
            $success['status'] = $user->status;
            $success['title'] = "Welcome Message";
            $success['name'] =  $success['first_name'];
            $success['body'] = "You have completed registration at KleanCor! Welcome to KleanCor! !";

            if ($request->referCode) {
                $code = DB::table('users')->select('id')->where('refer_code', $request->referCode)->first();
                if ($code) {
                    DB::table('referrals')->insert(['refer_id' => $user->id, 'referrer_id' => $code->id]);
                }
            }

            try {
                Mail::send('emails/new-user', ['user' => $user], function ($message) use ($user) {
                    $message->to($user['email'])->subject('Welcome to ' . config('app.name'));
                });
                Mail::send('emails/admin-new-user', ['user' => $user], function ($message) use ($user) {
                    $message->to(config('app.admin_email'))->subject('New user register to ' . config('app.name'));
                });
            } catch (\Throwable $th) {
                \Log::info($th);
            }
            return $this->sendResponse($success, 'User register successfully.');
        }
    }

    public function login(Request $request)
    {
        $auth_type = $request->auth_type;

        if ($auth_type == 1) {
            if (User::where('email', '=', $request->email)->first()) {
                $user = User::where('email', '=', $request->email)->first();
                $user['token'] =  $user->createToken('MyApp')->plainTextToken;
                return $this->sendResponse($user, 'User already registered.');
            } else {
                $refer_code = rand(10000, 99999);
                while (1) {
                    $code = DB::table('users')->select('refer_code')->where('refer_code', $refer_code)->first();
                    if ($code) $refer_code = rand(10000, 99999);
                    else break;
                }
                $input = $request->all();
                $input['refer_code'] = $refer_code;
                $user = User::create($input);
                $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                $success['id'] =  $user->id;
                $success['first_name'] =  $user->first_name;
                $success['last_name'] =  $user->last_name;
                $success['email'] =  $user->email;
                $success['address'] =  $user->address;
                $success['about'] =  $user->about;
                $success['price'] =  $user->price;
                $success['expertise_label'] =  $user->expertise_label;
                $success['contact'] =  $user->contact;
                $success['auth_type'] =  $user->auth_type;
                $success['refer_code'] =  $user->refer_code;
                $success['status'] = $user->status;


                if ($request->referCode) {
                    $code = DB::table('users')->select('id')->where('refer_code', $request->referCode)->first();
                    if ($code) {
                        DB::table('referrals')->insert(['refer_id' => $user->id, 'referrer_id' => $code->id]);
                    }
                }

                return $this->sendResponse($success, 'User register successfully.');
            }
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $locationId = $user->locations_id;
                $skillsId = $user->skills_id;
                $location_name = Location::where('id', '=', $locationId)->select('name')->first();
                $skills_name = Skill::where('id', '=', $skillsId)->select('name')->first();

                $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                $success['id'] =  $user->id;
                $success['email'] =  $user->email;
                $success['first_name'] =  $user->first_name;
                $success['last_name'] =  $user->last_name;
                $success['address'] =  $user->address;
                $success['about'] =  $user->about;
                $success['price'] =  $user->price;
                $success['expertise_label'] =  $user->expertise_label;
                $success['contact'] =  $user->contact;
                $success['location'] =  $location_name;
                $success['skills'] =  $skills_name;
                $success['refer_code'] =  $user->refer_code;
                $success['status'] = $user->status;



                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
        }
    }


    public function logout()
    {
        auth('api')->logout();

        return $this->sendResponse($success, 'Successfully logged out');
    }


    public function forgotpassword(request $request)
    {
        try {
            $user = User::where('email', $request->email)->get();

            if (count($user) > 0) {
                $token = rand(10, 1000000);
                // $token = '12345';
                $domain = URL::to('/');
                $url = $domain . '/resetpassword?token=' . $token;

                $data['url'] = $url;
                $data['token'] = $token;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on below link to reset your password !";

                Mail::send('forgotpassword', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                );

                return response([
                    'message' => 'Reset password mail has been sent to your email !'
                ], 200);
            } else {
                return response([
                    'message' => "User not found !"
                ], 400);
            }
        } catch (Exception $e) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }


    public function matchpincode(request $request)
    {
        try {
            $email = DB::table('password_resets')
                ->select('email')
                ->where('token', '=', $request->pincode)
                ->first();

            if ($email) {
                return response([
                    $email,
                    'message' => 'Your pincode is correct !'
                ], 200);
            } else {
                return response([
                    'message' => "Pincode does not match !"
                ], 400);
            }
        } catch (Exception $e) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function changepassword(request $request)
    {
        $request->validate([
            'password' => ['required'],
            'c_password' => ['same:password'],
        ]);


        $user = User::where('email', '=', $request->email)->update(['password' => bcrypt($request->password)]);

        if ($user) {
            return response([
                'message' => 'Password has been changed successfully! Please login.. !'
            ], 200);
        } else {
            return response([
                'message' => 'Your password change failed !'
            ], 400);
        }
    }
}
