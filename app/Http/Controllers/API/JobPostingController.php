<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController; // New Change
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\Payment;
use DateTime;
use Mail;
use DateTimeZone;
use App\Models\Notifications;
use App\Services\FirebaseService;
use App\Constants\NotificationTypes;
use App\Models\Document;

class JobPostingController extends BaseController // New Change
{
    private $settings;
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->settings = DB::table('settings')->first();
        $this->firebaseService = $firebaseService;
    }

    public function index(Request $request)
    {
        $data = $request->all();

        $job = new Job;
        $job->title = $data['categoryName'];
        $job->locations_id = $data['locationId'];
        $job->project_name = $data['projectsName'];
        $job->address = $data['streetAddress'];
        $job->job_type = $data['jobType'];
        $job->price = $data['price'];
        $job->categories_id = $data['categoryId'];
        $job->number_of_worker = $data['workerNumber'];
        $job->hours = $data['workingHour'];
        $job->week_type = $data['workingWeek'];
        $job->dead_line = JobPostingController::timeZoneConverter($data['date'], $data['timeZone'], $this->settings->time_zone);
        $job->house_keeping_list = $data['houseKeepingList'];
        $job->house_keeping_radio_list = json_encode($data['houseKeepingRadioList']);
        $job->contact = $data['email'];
        $job->poster_id = $data['userId'];
        $job->house_type = $data['houseType'];
        $job->main_entry = $data['mainEntry'];
        $job->skill_list = $data['skills'];
        $job->save();

        return $this->sendResponse($job, 'Job posted successfully.');
    }

    public function job_update(Request $request)
    {
        // echo 'hello';


        $success = $request->userInput;


        //  $success = '{"jobId":30,"userId":"6","categoryId":2,"categoryName":"Cleaning Service","timeZone":"Asia/Dhaka","locationId":6,"streetAddress":"Test street","jobType":2,"price":100,"workerNumber":2,"workingHour":6,"workingWeek":1,"houseKeepingList":"[{\"id\":7,\"name\":\"Bedroom\",\"min_val\":0,\"max_val\":10,\"default_val\":1},{\"id\":2,\"name\":\"Entry\",\"min_val\":0,\"max_val\":10,\"default_val\":2},{\"id\":5,\"name\":\"Family Area\",\"min_val\":0,\"max_val\":10,\"default_val\":1},{\"id\":4,\"name\":\"Kitchen\",\"min_val\":0,\"max_val\":10,\"default_val\":1},{\"id\":1,\"name\":\"Living Room\",\"min_val\":0,\"max_val\":10,\"default_val\":2}]","email":"admin@gmail.com","date":"12/15/2022, 8:28:28 AM","houseType":2,"mainEntry":2}';
        // DB::table('test_table')->insert(['name'=>$success]);
        $data = json_decode($success);
        // print_r($data);

        if (strpos($data->date, ',') === false) {
            $data->date = str_replace(' ', ',', $data->date);
        }

        $job = Job::where('id', $data->jobId)
            ->update([
                'locations_id' => $data->locationId,
                'address' => $data->streetAddress,
                'project_name' => $data->projectsName,
                'job_type' => $data->jobType,
                'price' => $data->price,
                'number_of_worker' => $data->workerNumber,
                'hours' => $data->workingHour,
                'week_type' => $data->workingWeek,
                'house_keeping_list' => $data->houseKeepingList,
                'house_keeping_radio_list' => json_encode($data->houseKeepingRadioList),
                'contact' => $data->email,
                'dead_line' => JobPostingController::timeZoneConverter($data->date, $data->timeZone, $this->settings->time_zone),
                'house_type' => $data->houseType,
                'main_entry' => $data->mainEntry,
                'skill_list' => $data->skills
            ]);

        if ($job) {
            return response([
                'message' => 'Job Updated Successfully'
            ], 200);
        } else {
            return response([
                'message' => 'Job Updated failed !'
            ], 400);
        }
    }

    public static function timeZoneConverter($time = "", $fromTz = '', $toTz = '')
    {
        $time = explode(',', $time);
        $time[1]  = date("H:i:s", strtotime($time[1]));
        $date = new DateTime(implode(' ', $time), new DateTimeZone($fromTz));
        $date->setTimezone(new DateTimeZone($toTz));
        $time = $date->format('Y-m-d H:i:s');
        return $time;
    }

    public function job_deatils($id, $userId)
    {
        $data = DB::table("jobs")
            ->select(
                'jobs.*',
                'users.first_name as cFname',
                'users.id as cId',
                'users.last_name as cLname',
                'users.avatar as userImg',
                'users.gender',
                'locations.name as locName',
                'locations.zip',
                'categories.picture as cpic',
                'categories.name as catName',
                'jobs.categories_id',
                DB::raw("(select count(a.id) from applications as a where a.jobs_id=jobs.id and a.users_id=$userId) as applied")
            )
            ->join('users', 'users.id', '=', 'jobs.poster_id')
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->join('categories', 'categories.id', '=', 'jobs.categories_id')
            ->where('jobs.id', $id)
            ->orderBy("id", "desc")
            ->first();
        return response()->json($data);
    }

    public function job_apply(Request $request)
    {
        $success = $request->userInput;
        // DB::table('test_table')->insert(['name'=>$success]);
        $data = json_decode($success);
        $arr = [
            'jobs_id' => $data->jobId,
            'users_id' => $data->userId
        ];

        $applications = DB::table('applications')->insert($arr);

        $userData = DB::table('users')->select('first_name', 'last_name')->where('id', $data->userId)->first();

        $jobData = DB::table('jobs')
            ->select(
                'jobs.poster_id',
                'jobs.title',
                'users.fcm_token'
            )
            ->join('users', 'users.id', '=', 'jobs.poster_id')
            ->where('jobs.id', $data->jobId)->first();

        if (isset($jobData->fcm_token) && $jobData->fcm_token != null) {

            $deviceToken = $jobData->fcm_token;
            $title = 'New Job Application';
            $body = $userData->first_name . ' ' . $userData->last_name . ' has applied for your job ' . $jobData->title;

            $notification = Notifications::create([
                'users_id' =>  $jobData->poster_id,
                'title' => $title,
                'status' => 0,
                'message' => $body,
                'notification_type_id' => NotificationTypes::NEW_JOB_APPLICATION
            ]);

            $response = $this->firebaseService->sendNotification($deviceToken, $title, $body);
        }

        return response()->json($applications);
    }


    public function job_edit($id, $timeZone)
    {
        $data = DB::table("jobs")
            ->select('*')
            ->find($id);
        $data->dead_line = JobPostingController::timeZoneConverter(str_replace(' ', ',', $data->dead_line), $this->settings->time_zone, 'Asia/Dhaka');
        return response()->json($data);
    }
    public function job_list($start, $status)
    {
        $data['jobList'] = DB::table("jobs")
            ->select(
                'jobs.id',
                'jobs.title',
                'jobs.job_type',
                'jobs.price',
                'locations.name as lname',
                'locations.zip',
                'categories.picture',
                'categories.name as catName',
                'jobs.categories_id',
                'users.avatar', // New Change
                DB::raw('(select count(j.id) from jobs as j where j.poster_id=jobs.poster_id and j.status<5) as totalJobs'),
                DB::raw("IFNULL(ROUND((jobs.client_rating1 + jobs.client_rating2 + jobs.client_rating3) / 3, 2), 0) as totalStar")
            )
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->join('categories', 'categories.id', '=', 'jobs.categories_id')
            ->join('users', 'users.id', '=', 'jobs.poster_id') // New Change
            ->where('jobs.status', $status)
            ->skip($start)->take($this->settings->job_limit)
            ->orderBy("id", "desc")
            ->get();

        $data['totalJob'] = DB::table('jobs')->where('jobs.status', $status)->count();

        return response()->json($data);
    }

    public function profile_job_list($start, $status, $userId, $type)
    {
        $sql = DB::table("jobs")
            ->select(
                'jobs.id',
                'jobs.title',
                'jobs.job_type',
                'jobs.price',
                'jobs.project_name',
                'jobs.poster_id as cid',
                'jobs.address',
                'locations.name as locName',
                'locations.zip',
                'categories.picture',
                'categories.name as catName',
                'jobs.categories_id',
                'jobs.final_price',
                'jobs.final_hour',
                'jobs.status',
                'jobs.awards_id',
                'jobs.worker_comment',
                DB::raw('(select count(j.id) from jobs as j where j.poster_id=jobs.poster_id and j.status<5) as totalJobs')
            )
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->join('users', 'users.id', '=', 'jobs.poster_id')
            ->join('categories', 'categories.id', '=', 'jobs.categories_id');

        if ($status == 1) {
            $sql->where('jobs.status', '<=', 2);
            $sql->where('jobs.poster_id', $userId);
        } else if ($type === 'offer') {
            $sql->where('jobs.status', $status);
            $sql->where('jobs.awards_id', $userId);
        } else if ($status == 3 || $status == 4) {
            $sql->where(function ($query) use ($userId) {
                return $query->where('jobs.awards_id', $userId)->orWhere('jobs.poster_id', $userId);
            });
            $sql->whereBetween('jobs.status', [3, 4]);
        } else if ($status == 5) {
            $sql->where(function ($query) use ($userId) {
                return $query->where('jobs.awards_id', $userId)->orWhere('jobs.poster_id', $userId);
            });
            $sql->where('jobs.status', 5);
        } else {
            $sql->where('jobs.status', $status);
            $sql->where('jobs.poster_id', $userId);
        }

        $data['jobData'] = $sql->skip($start)->take($this->settings->job_limit)
            ->orderBy("jobs.id", "desc")
            ->get();
        $data['totalJob'] = Job::where('poster_id', $userId)->where('status', $status)->count();
        return response()->json($data);
    }

    public function proposal_list($jobId)
    {
        $data = DB::table("users")
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.about',
                'users.gender',
                'users.avatar as rImg'
            )
            ->join('applications', 'applications.users_id', '=', 'users.id')
            ->where('applications.jobs_id', $jobId)
            ->orderBy("id", "asc")
            ->get();


        // $data = DB::table('channels')
        //                 ->select(
        //                             'channels.name', 'su.id as sid', 'ru.id as rid',
        //                             DB::raw("(select message from messages where channels.id=messages.channel_id order by messages.id desc limit 1) as last_message")
        //                         )
        //                 ->leftJoin('users as su', 'su.id', '=', 'channels.sender_id')
        //                 ->leftJoin('users as ru', 'ru.id', '=', 'channels.receiver_id')
        //                 ->where('channels.sender_id', $request->sender_id)
        //                 ->where('channels.receiver_id', $request->receiver_id)
        //                 ->first();


        return response()->json($data);
    }

    public function complete_hire(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);
        $job = Job::where('id', $data->jobId)
            ->update([
                'awards_id' => $data->userId,
                'final_price' => $data->amount,
                'status' => 2
            ]);

        if ($job) {
            return response([
                'message' => 'Job Updated Successfully'
            ], 200);
        } else {
            return response([
                'message' => 'Job Updated failed !'
            ], 400);
        }
    }

    public function recent_search_save(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);
        $result = DB::table('recent_searches')->where('user_id', $data->userId)->where('keyword', $data->keyword)->first();
        if (!$result) {
            DB::table('recent_searches')->insert(['user_id' => $data->userId, 'keyword' => $data->keyword]);
        }
    }

    public function recent_search($userId)
    {
        $data = DB::table('recent_searches')->select('keyword')->where('user_id', $userId)->orderBy('id', 'desc')->limit(10)->get();
        return response()->json($data);
    }

    public function job_search($keyword)
    {
        $data['category'] = DB::table('categories')
            ->select('name')
            ->where('name', 'like', "%{$keyword}%")
            ->limit(5)
            ->orderBy('name', 'asc')
            ->get();

        $data['location'] = DB::table('locations')
            ->select('name', 'zip')
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('zip', 'like', "%{$keyword}%")
            ->limit(5)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($data);
    }

    public function job_list_search($keyword, $start, $status)
    {
        $data['jobList'] = DB::table("jobs")
            ->select(
                'jobs.id',
                'jobs.title',
                'jobs.job_type',
                'jobs.price',
                'locations.name as lname',
                'locations.zip',
                'categories.picture',
                'categories.name as catName',
                'jobs.categories_id',
                'users.avatar', //new
                DB::raw('(select count(j.id) from jobs as j where j.poster_id=jobs.poster_id and j.status<5) as totalJobs')
            )
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->join('categories', 'categories.id', '=', 'jobs.categories_id')
            ->join('users', 'users.id', '=', 'jobs.poster_id') // New Change
            ->where('jobs.status', $status)
            ->where(function ($query) use ($keyword) {
                return $query->where('locations.name', 'like', "%{$keyword}%")->orWhere('locations.zip', 'like', "%{$keyword}%")->orWhere('jobs.title', 'like', "%{$keyword}%");
            })
            ->skip($start)->take($this->settings->job_limit)
            ->orderBy("id", "desc")
            ->get();

        $data['totalJob'] = DB::table("jobs")
            ->select(
                'jobs.id',
                'jobs.title',
                'jobs.job_type',
                'jobs.price',
                'locations.name as lname',
                'locations.zip',
                'categories.picture',
                'categories.name as catName',
                'jobs.categories_id',
                'users.avatar', //new
                DB::raw('(select count(j.id) from jobs as j where j.poster_id=jobs.poster_id and j.status<5) as totalJobs')
            )
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->join('categories', 'categories.id', '=', 'jobs.categories_id')
            ->join('users', 'users.id', '=', 'jobs.poster_id') // New Change
            ->where('jobs.status', $status)
            ->where(function ($query) use ($keyword) {
                return $query->where('locations.name', 'like', "%{$keyword}%")->orWhere('locations.zip', 'like', "%{$keyword}%")->orWhere('jobs.title', 'like', "%{$keyword}%");
            })->count();


        return response()->json($data);
    }

    public function payment(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);

        $job_category_id = $data->job_category_id;
        $client_id = $data->client_id;

        $isFoundStatus = DB::table("users")
            ->select('status')
            ->where('status', 0)
            ->where('id', $client_id)
            ->first();

        $isFoundClient = DB::table("referrals")
            ->select('refer_id')
            ->where('refer_id', $client_id)
            ->first();

        if ($isFoundClient == null) {
            $isFoundClient = DB::table("referrals")
                ->select('referrer_id')
                ->where('referrer_id', $client_id)
                ->first();
        }

        $isJobFound = DB::table("categories")
            ->select('id')
            ->where('id', $job_category_id)
            ->first();

        if (
            $isFoundStatus &&
            $isFoundClient && $isJobFound
        ) {
            //payment should be less 15%

            DB::table('users')->where($isFoundStatus->status)->update(['status' => 1]);
        } else {
            //payment normally
        }
    }

    public function accept_offer(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);
        DB::table('jobs')->where('id', $data->jobId)->update(['status' => $data->status]);
    }

    public function complete_review(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);
        if ($data->type == 'client') {
            $jobData = DB::table('jobs')->where('id', $data->jobId)->first();
            $total_amount = 0;
            if ($jobData->job_type == 1) {
                $total_amount = $jobData->final_price * $data->totalHour;
            } else {
                $total_amount = $jobData->final_price;
            }

            $arr = [
                'client_recommended' => $data->recommended,
                'client_rating1' => $data->survey1,
                'client_rating2' => $data->survey2,
                'client_rating3' => $data->survey3,
                'final_hour' => $data->totalHour,
                'client_comment' => $data->comment,
                'total_amount' => $total_amount,
                'status' => 5
            ];
        } else {
            $arr = [
                'worker_rating1' => $data->survey1,
                'worker_rating2' => $data->survey2,
                'worker_rating3' => $data->survey3,
                'worker_comment' => $data->comment
            ];
        }

        DB::table('jobs')->where('id', $data->jobId)->update($arr);
    }

    public function load_worker_profile($id)
    {
        $data['userInfo'] = DB::table('users')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.skill_list',
                'users.location_list',
                'users.about',
                'users.email',
                'users.gender',
                'users.address',
                'users.avatar as userImg',
                'users.created_at',
                'locations.name as locName',
                'locations.zip as zip',
                'users.is_verified_document',
                'users.year_of_experience',
                'users.service_offer',
                'users.availability',
                'users.insurance_img',
                'users.rates',
                'users.service_areas',
                'users.facebook_url',
                'users.twitter_url',
                'users.instagram_url',
                'users.linked_in_url',
                DB::raw("(select sum(jobs.final_hour) from jobs where jobs.awards_id='{$id}' and status=5) as totalHours"),
                DB::raw("(select sum(jobs.total_amount) from jobs where jobs.awards_id='{$id}' and status=5) as totalAmount"),
                DB::raw("(select sum(jobs.client_recommended) from jobs where jobs.awards_id='{$id}' and status=5) as totalRecommended"),
                DB::raw("(select count(jobs.id) from jobs where jobs.awards_id='{$id}' and status=5) as totalJobs"),
                DB::raw("(select sum((jobs.client_rating1 + jobs.client_rating2 + jobs.client_rating3)/3) from jobs where jobs.awards_id='{$id}' and status=5) as totalStar")
            )
            ->leftJoin('locations', 'locations.id', '=', 'users.client_location')
            ->where('users.id', $id)
            ->first();

        $userDocuments = Document::toBase()->where('user_id', $id)->select('type', 'document_url')->get();


        if ($userDocuments->count() > 0) {
            if ($data['userInfo']->insurance_img) {
                $userDocuments->push([
                    'document_url' => $data['userInfo']->insurance_img,
                    'type' => 'insurance_img'
                ]);
            }
        }

        $data['userInfo']->documents = $userDocuments;

        return response()->json($data);
    }

    public function load_client_profile($id)
    {
        $data['userInfo'] = DB::table('users')
            ->select(
                'users.first_name',
                'users.last_name',
                'users.about',
                'users.gender',
                'users.created_at',
                'users.avatar as userImg',
                'locations.name as locName',
                'locations.zip as zip',
                'users.created_at',
                DB::raw("(select sum(jobs.total_amount) from jobs where jobs.poster_id='{$id}' and status=5) as totalAmount"),
                DB::raw("(select count(jobs.id) from jobs where jobs.poster_id='{$id}' and status=5) as totalJobs"),
                DB::raw("(select count(jobs.id) from jobs where jobs.poster_id='{$id}' and status<=5) as totalPosts"),
                DB::raw("(select count(jobs.id) from jobs where jobs.poster_id='{$id}' and status>=3 and status<=4) as totalActive"),
                DB::raw("(select count(jobs.id) from jobs where jobs.poster_id='{$id}' and status>=3 and status<=5) as totalHire"),
                DB::raw("(select count(jobs.id) from jobs where jobs.poster_id='{$id}' and status<=5 and jobs.worker_rating1>0) as totalRating"),
                DB::raw("(select sum((jobs.worker_rating1 + jobs.worker_rating2 + jobs.worker_rating3)/3) from jobs where jobs.poster_id='{$id}' and status=5) as totalStar")
            )
            ->leftJoin('locations', 'locations.id', '=', 'users.client_location')
            ->where('users.id', $id)
            ->first();
        return response()->json($data);
    }

    public function recent_category_search_save(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);
        $result = DB::table('recent_category_searches')->where('user_id', $data->userId)->where('keyword', $data->keyword)->first();
        if (!$result) {
            DB::table('recent_category_searches')->insert(['user_id' => $data->userId, 'keyword' => $data->keyword]);
        }
    }

    public function recent_category_search($userId)
    {
        $data = DB::table('recent_category_searches')->select('keyword')->where('user_id', $userId)->orderBy('id', 'desc')->limit(5)->get();
        return response()->json($data);
    }

    public function completed_job_info(Request $request)
    {

        $invoice_number = date('YmdHis') . rand(100, 999);
        $worker_id = DB::table('applications')
            ->where('jobs_id', $request->job_id)
            ->value('users_id');

        $completedData = Payment::create([
            'client_id' =>  $request->client_id,
            'worker_id' => $worker_id,
            'job_category_id' => $request->job_category_id,
            'invoice_number' => $invoice_number,
            'amount' => $request->amount,
            'payment_date' => now(),
            'status' => 0,
            'total_hour' => $request->total_hour,
            'last_update' => now(),
        ]);

        $workerDetails = DB::table('users')
            ->select('email', 'first_name')
            ->where('id', $worker_id)
            ->first();



        $invoice = [
            'title' => 'Invoice Information',
            'header' => 'Your invoice information is given below->',
            'amount' => $request->amount,
            'hour' => $request->total_hour,
            'total_amount' => $request->amount * $request->total_hour,
            'invoice_number' => $invoice_number,
            'item_name' => $request->category_name,
            'invoice_date' => now(),
            'email' => $workerDetails->email,
            'name' => $workerDetails->first_name,
        ];

        Mail::send('invoiceinfo', ['invoice' => $invoice], function ($invoiceMessage) use ($invoice) {
            $invoiceMessage->to($invoice['email'])->subject($invoice['title']);
        });

        if ($completedData) {
            return response([
                'message' => 'Completed Job info Saved Successfully'
            ], 200);
        } else {
            return response([
                'message' => 'Completed Job info Saved failed !'
            ], 400);
        }
    }

    public function worker_completed_jobs($start, $userId)
    {
        $data['jobData'] = DB::table("jobs")
            ->select(
                'jobs.id',
                'jobs.title',
                'jobs.job_type',
                'jobs.price',
                'jobs.project_name',
                'jobs.poster_id as cid',
                'jobs.address',
                'locations.name as locName',
                'locations.zip',
                'categories.picture',
                'categories.name as catName',
                'jobs.categories_id',
                'jobs.final_price',
                'jobs.status',
                'jobs.awards_id',
                'jobs.worker_comment',
                DB::raw('(select count(j.id) from jobs as j where j.poster_id=jobs.poster_id and j.status<5) as totalJobs')
            )
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->join('users', 'users.id', '=', 'jobs.poster_id')
            ->join('categories', 'categories.id', '=', 'jobs.categories_id')
            ->where('jobs.status', 5)
            ->where('jobs.awards_id', $userId)
            ->skip($start)->take($this->settings->job_limit)
            ->orderBy("jobs.id", "desc")
            ->get();
        $data['totalJob'] = Job::where('awards_id', $userId)->where('status', 5)->count();
        return response()->json($data);
    }

    public function client_offer_list($userId)
    {
        $data = DB::table("users")
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.about',
                'users.gender',
                'jobs.project_name',
                'users.avatar as rImg',
                'jobs.status',
                'jobs.title as categoryName',
                'jobs.address',
                'locations.name as locName',
                'locations.zip',
                'jobs.job_type',
                'jobs.price',
                'jobs.id as jobId'
            )
            ->join('applications', 'applications.users_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'applications.jobs_id')
            ->join('locations', 'locations.id', '=', 'jobs.locations_id')
            ->where('jobs.poster_id', $userId)
            ->where('jobs.status', '=', 1)
            ->orderBy("applications.id", "asc")
            ->get();
        return response()->json($data);
    }
}
