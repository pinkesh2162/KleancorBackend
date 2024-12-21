<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
use Mail;
   
class ProfileController extends BaseController
{
    public function getProfile(request $request){
        $data['userData'] = DB::table("users")
        ->select('id', 'first_name', 'last_name', 'email', 'address', 'about', 'price', 'expertise_label', 'contact', 'avatar', 'insurance_img', 'users.location_list as lid', 'users.skill_list as sid', 'users.client_location as Clid', 'users.category_list as cateid')
        ->where('id', $request->id)
        ->first();


        $locations = $data['userData']->Clid;
        $locations_id = explode(',', $locations);
        $data['locationData'] = DB::table('locations')->select('name', 'zip')->whereIn('id', $locations_id)
      ->get();

        return response()->json($data);
    }

    public function skills(request $request){
        $data = DB::table("skills")
        ->select('id', 'name', 'status')
        ->get();
        return response()->json($data);
    }

    public function locations(request $request){
        $data = DB::table("locations")
        ->select('id', 'name', 'zip', 'status')
        ->get();
        return response()->json($data);
    }


    public function profile_update(request $request) {
        // $success = $request->userInput;
        // $success = '{"first_name":"sahed","last_name":"ahmed","address":"satkhira","about":"dfgdfghdfhdfhfhhfhhdfhdf","price":"1","expertise_label":"gewrtt","contact":"5325235","locations_id":"[{\"id\":5,\"name\":\"Missouri\",\"zip\":\"63001\"},{\"id\":7,\"name\":\"Nevada\",\"zip\":\"88901\"},{\"id\":2,\"name\":\"Pittsburgh\",\"zip\":\"15210\"}]","skills_id":"[{\"id\":4,\"name\":\"Painting\",\"status\":1},{\"id\":6,\"name\":\"Assembling\",\"status\":1}]"}';
        // $data = json_decode($success);
        
        // echo "<pre>";
        // print_r($data);
        // die();
       
       $user = User::where('id', $request->id)
                    ->update([
                        'first_name'=> $request->first_name,
                        'last_name'=> $request->last_name,
                        'address'=> $request->address,
                        'about'=> $request->about,
                        'price'=> $request->price,
                        'expertise_label'=> $request->expertise_label,
                        'contact'=> $request->contact,
                        'location_list'=> $request->locations_id,
                         'skill_list'=> $request->skills_id,
                        'category_list'=> $request->categories_id
                    ]);

            if($user){
                return response([
                    'message'=>'Your Profile Updated Successfully'
                    ],200); 
            }else{
                return response([
                    'message'=>'Your Profile Updated failed !'
                    ],400);
            }  

    }


    public function client_profile_update(request $request) {
        // $success = $request->userInput;
   
  
        // $data = json_decode($success);
        
        $user = User::where('id', $request->id)
                    ->update([
                        'first_name'=> $request->first_name,
                        'last_name'=> $request->last_name,
                        'contact'=> $request->contact,
                        'client_location'=> $request->location_id,
                        'address' => $request->address,
                    ]);

            if($user){
                return response([
                    'message'=>'Your Profile Updated Successfully'
                    ],200); 
            }else{
                return response([
                    'message'=>'Your Profile Updated failed !'
                    ],400);
            }  

    }
    
    
    public function categories(request $request){
        $data = DB::table("categories")
            ->select('id', 'name', 'spanish_name', 'status')
        ->get();
        return response()->json($data);
    }
    
    
    public function saveFcm(Request $request) {
       
        $success = $request->userFcm;

        $data = json_decode($success);
        
        $user = User::where('id', $data->id)
                    ->update([
                        'fcm_token'=> $data->fcm_token,
                    ]);

            if($user){
                return response([
                    'message'=>'Your token saved Successfully'
                    ],200); 
            }else{
                return response([
                    'message'=>'Your token saved failed !'
                    ],400);
            }  

    }

        public function saveNotifications(Request $request) {
        
        $notification = Notifications::create([
            'users_id' =>  $request->user_id,
            'title' => $request->title,
            'status' => 0,
            'message' => $request->message,
        ]);

        $user = User::find($request->user_id);
        $applyNotification = array(
            'name' => $user->first_name,
            'email' => $user->email,
            'title' => $request->title,
            'message' => $request->message,
        );
        $hireNotification = array(
            'name' => $user->first_name,
            'email' => $user->email,
            'title' => $request->title,
            'message' => $request->message,
        );
        $offerNotification = array(
            'name' => $user->first_name,
            'email' => $user->email,
            'title' => $request->title,
            'message' => $request->message,
        );
        $completeNotification = array(
            'name' => $user->first_name,
            'email' => $user->email,
            'title' => $request->title,
            'message' => $request->message,
        );
        
        if($request->title == 'Apply Notification'){
            Mail::send('apply', ['applyNotification' => $applyNotification], function ($applyMessage) use ($applyNotification) {
                $applyMessage->to($applyNotification['email'])->subject($applyNotification['title']);
            });
        } else if ($request->title == 'Hire Notification'){
            Mail::send('hire', ['hireNotification' => $hireNotification], function ($hireMessage) use ($hireNotification) {
                $hireMessage->to($hireNotification['email'])->subject($hireNotification['title']);
            });
        } else if ($request->title == 'Offer Accept Notification'){
            Mail::send('offerAccept', ['offerNotification' => $offerNotification], function ($offerMessage) use ($offerNotification) {
                $offerMessage->to($offerNotification['email'])->subject($offerNotification['title']);
            });
        } else if ($request->title == 'Completed Job Notification'){
            Mail::send('completeJob', ['completeNotification' => $completeNotification], function ($completeMessage) use ($completeNotification) {
                $completeMessage->to($completeNotification['email'])->subject($completeNotification['title']);
            });
        }

            if($notification){
                return response([
                    'message'=>'Notification saved Successfully'
                    ],200); 
            }else{
                return response([
                    'message'=>'Notification saved failed !'
                    ],400);
            }  

    }
    
    
    public function getNotifications(Request $request) {
        $data= DB::table("notifications")
        ->select('id', 'users_id', 'title', 'message', 'status')
        ->where('users_id', $request->id)
        ->orderBy('id', 'desc')
        ->get();

        return response()->json($data);

    }
    public function updateNotifications(Request $request) {
        $data= DB::table("notifications")
        ->where('status', 0)
        ->where('users_id', $request->id)
        ->update([
            'status' => 1
        ]);

        if($data){
            return response()->json(['status '=> true]);
        }
    }

    public function getLatestNotifyRows(Request $request) {
        $data= DB::table("notifications")
        ->where('users_id', $request->id)
        ->where('status', 0)
        ->count();

        if($data){
            return response()->json($data);
        }
    }

    public function getFcm(Request $request) {
        $data= DB::table("users")
        ->select('id', 'fcm_token')
        ->where('id', $request->id)
        ->get();

        return response()->json($data);

    }
    
     public function sent_refer(Request $request) {
        
            $referData = DB::table('sent_refer_codes')->insert([
                'user_id'=>$request->user_id, 
                'number' =>  $request->number,
                'status' => 0
                ]);

            if($referData){
                return response([
                    'message'=>'Refer Info saved Successfully'
                    ],200); 
            }else{
                return response([
                    'message'=>'Refer Info saved failed !'
                    ],400);
            } 

    }
    
      public function get_refer_numbers(Request $request) {
        
       $data= DB::table("sent_refer_codes")
        ->select('number')
        ->where('user_id', $request->id)
        ->get();

        return response()->json($data);
      }
      
      public function get_refer_info(Request $request) {
        
       $cdata= DB::table("referrals")
        ->where('referrer_id', $request->id)
        ->get();
        
         $pdata= DB::table("sent_refer_codes")
        ->where('user_id', $request->id)
        ->get();
        
         $rdatas= DB::table("referrals")
         ->select('first_name', 'last_name')
         ->join('users', 'users.id', '=', 'referrals.refer_id')
        ->where('referrals.referrer_id', $request->id)
        ->orderBy('referrals.id', 'desc')
        ->limit(5)
        ->get();
      
        $info['completed'] = $cdata->count();
        $info['pending'] = $pdata->count();
        $info['recent'] = $rdatas;

       
       return response()->json($info);
      }
      
   
      public function delete_profile(Request $request) {

          
       $deletedUser = User::where('id', $request->id)
                    ->update([

                       'first_name'=>'KleanCor',
                        'last_name'=>'User',
                        'email'=>'deleteduser' . rand(0, 9999) . '@email.com',
                        'refer_code'=>'000',
                        'address'=>null,
                        'about'=>null,
                        'contact'=>'0000000',
                        'avatar'=>null,
                    ]);

                if($deletedUser){
                    return response([
                        'message'=>'User Deleted Successfully'
                        ],200); 
                }else{
                    return response([
                        'message'=>'User Deleted failed !'
                        ],400);
                }  ;
      }
      
      
      public function get_invoices_info(Request $request) {

      $data = DB::table("payments")
            ->select('payments.*', 'categories.name as job_name')
            ->join('categories', 'payments.job_category_id', '=', 'categories.id')
            ->where('client_id', $request->id)
            ->orWhere('worker_id', $request->id)
            ->get();

        return response()->json($data);
   
      }
}