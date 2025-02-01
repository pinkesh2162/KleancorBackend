<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController; // New Change
use App\Models\JobHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\Payment;
use DateTime;
use Mail;
use DateTimeZone;
use App\Models\Notifications;
use App\Models\User;
use App\Services\FirebaseService;
use App\Constants\NotificationTypes;
use App\Models\Application;
use App\Models\Document;
use Carbon\Carbon;

class JobPostingController extends BaseController // New Change
{
    private $settings;
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->settings = DB::table('settings')->first();
        $this->firebaseService = $firebaseService;
    }

//    public function index(Request $request)
//    {
//        $jobs = Job::with([
//            'location:id,name,zip',
//            'category:id,name,picture',
//            'user:id,avatar'
//        ])
//            ->select([
//                'jobs.id',
//                'jobs.title',
//                'jobs.job_type',
//                'jobs.price',
//                'jobs.poster_id',
//                'jobs.locations_id',
//                'jobs.categories_id',
//                'jobs.status',
//                DB::raw('(SELECT COUNT(j.id) FROM jobs AS j WHERE j.poster_id = jobs.poster_id AND j.status < 5) AS totalJobs'),
//                DB::raw("IFNULL(ROUND((jobs.client_rating1 + jobs.client_rating2 + jobs.client_rating3) / 3, 2), 0) AS totalStar")
//            ])
//            ->filter($request->only(['status', 'exclude_user']))
//            ->skip($request->start)
//            ->take($this->settings->job_limit)
//            ->orderBy("jobs.id", "desc")
//            ->get();
//
//        return response()->json($jobs);
//    }

    public function store(Request $request)
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

    public function edit(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        
        $job->dead_line = JobPostingController::timeZoneConverter(str_replace(' ', ',', $job->dead_line), $this->settings->time_zone, 'Asia/Dhaka');
        return response()->json($job);
    }

    public function job_edit($id, $timeZone)
    {
        $data = DB::table("jobs")
            ->select('*')
            ->whereNull('deleted_at')
            ->find($id);
        $data->dead_line = JobPostingController::timeZoneConverter(str_replace(' ', ',', $data->dead_line),
            $this->settings->time_zone, 'Asia/Dhaka');

        return response()->json($data);
    }
        
        public function job_apply(Request $request)
    {
        $success = $request->userInput;
//        $success = json_encode($success);
        $data = json_decode($success);  

        $arr = [
            'jobs_id' => $data->jobId,
            'users_id' => $data->userId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        
        DB::beginTransaction();
        try {
            $applications = DB::table('applications')->insert($arr);

            $userData = DB::table('users')->select('first_name', 'last_name')->where('id', $data->userId)->first();

            $jobData = DB::table('jobs')
                ->select(
                    'jobs.id',
                    'jobs.poster_id',
                    'jobs.title',
                    'users.fcm_token',
                    'jobs.exclude_users',
                    'jobs.disable_ids'
                )
                ->join('users', 'users.id', '=', 'jobs.poster_id')
                ->whereNull('jobs.deleted_at')
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

//            $excludeUsers = $jobData->exclude_users;
//            if (empty($excludeUsers)) {
//                $excludeUsers = [(int)$data->userId];
//            } else {
//                array_push($excludeUsers, $data->userId);
//            }
//
            $disable_ids = $jobData->disable_ids;
            if (empty($disableUsers)) {
                $disable_ids = [(int)$data->userId];
            } else {
                array_push($disable_ids, (int)$data->userId);
            }
            Job::where('id',$jobData->id)->first()->update(['disable_ids' => $disable_ids]);
            DB::commit();
            
            return response()->json($applications);
        }catch (\Exception $exception){
            DB::commit();
            return response()->json($exception->getMessage());
        }
    }


//    public function jobApply(Request $request)
//    {
//        DB::beginTransaction();
//        try {
//            $input = $request->all();
//            $applications = Application::create([
//                'jobs_id'  => $input['job_id'],
//                'users_id' => $input['user_id'],
//            ]);
//
//            $user = User::findOrFail((int)$input['user_id']);
//            $job = Job::with('user')->findOrFail($input['job_id']);
//            if (isset($job->fcm_token) && $job->fcm_token != null) {
//                $deviceToken = $job->fcm_token;
//                $title = 'New Job Application';
//                $body = $user->first_name.' '.$user->last_name.' has applied for your job '.$job->title;
//
//                Notifications::create([
//                    'users_id'             => $job->poster_id,
//                    'title'                => $title,
//                    'status'               => 0,
//                    'message'              => $body,
//                    'notification_type_id' => NotificationTypes::NEW_JOB_APPLICATION,
//                ]);
//
//                $this->firebaseService->sendNotification($deviceToken, $title, $body);
//            }
//
//            $excludeUsers = $job->exclude_users;
//            if (empty($excludeUsers)) {
//                $excludeUsers = [(int)$input['user_id']];
//            } else {
//                array_push($excludeUsers, $input['user_id']);
//            }
//            
//            $job->update(['exclude_users' => $excludeUsers]);
//            
//            DB::commit();
//            return response()->json($applications);   
//        }catch (\Exception $exception){
//            DB::rollBack();
//            return response()->json($exception->getMessage(), $exception->getCode());
//        }
//    }
    
    //proposal list
//    public function jobApplyList(Request $request){
//        $users = User::whereHas('application', function($query)use($request){
//            return $query->where('jobs_id',$request->job_id);
//        })
//            ->select('id','first_name','last_name','about','gender','avatar')
//            ->orderBy("id", "asc")->get();
//        
//        return response()->json($users);
//    }
    
//    hire worker
//    public function hireWorkerByClient(Request $request)
//    {
//        $input = $request->all();
//        $job = Job::findOrFail($input['job_id']);
//        $job->update([
//            'awards_id'   => $input['user_id'],
//            'final_price' => $input['amount'],
//            'status'      => Job::HIRED,
//        ]);
//
//        return response([
//            'message' => 'Job Updated Successfully',
//        ], 200);
//    }

    //accept client job by worker 
//    public function acceptClientJobOffer(Request $request)
//    {
//        Job::findOrFail($request->job_id)->update(['status' => Job::ACCEPT]);
//    }
//
//    //reject client job by worker
//    public function rejectClientJobOffer(Request $request){
//        $job = Job::findOrFail($request->job_id);
//
//        $excludeUsers = $job->exclude_users;
//        if (empty($excludeUsers)) {
//            $excludeUsers = [$job->awards_id];
//        } else {
//            array_push($excludeUsers, $job->awards_id);
//        }
//
//        Application::where('jobs_id', $data->jobId)->where('users_id', $job->awards_id)->delete();
//
//        DB::table('jobs')->whereNull('deleted_at')->where('id', $data->jobId)->update([
//            'awards_id' => null,
//            'final_price' => null,
//            'status' => Job::NEW,
//            'exclude_users' => $excludeUsers
//        ]);
//    }

    public function requestInformation(Request $request)
    {
        $job = Job::findOrFail($request->jobId);
        $client = User::findOrFail($job->poster_id);
        $worker = User::findOrFail($request->userId);
        if (isset($client->fcm_token) && $client->fcm_token != null) {
            $deviceToken = $client->fcm_token;
            $title = 'Request Information';

            $body = $worker->first_name.' '.$worker->last_name.'has request for information about'.$job->title;
            Notifications::create([
                'users_id'             => $job->poster_id,
                'title'                => $title,
                'status'               => 0,
                'message'              => $body,
                'notification_type_id' => NotificationTypes::REQUEST_INFORMATION,
            ]);

            $this->firebaseService->sendNotification($deviceToken, $title, $body);

            return response()->json(['error' => false,'message' => 'Request information send successfully.']);
        }

        return response()->json(['error' => true,'message' => 'Client not available']);
    }
    
    public function completeRequestWorker(Request $request){
        $job = Job::findOrFail($request->jobId);
        $client = User::findOrFail($job->poster_id);
        $worker = User::findOrFail($request->userId);
        if (isset($client->fcm_token) && $client->fcm_token != null) {
            $deviceToken = $client->fcm_token;
            $title = 'Job Complete Request';

            $body = $worker->first_name.' '.$worker->last_name.' has requested to complete this'.$job->title.' job';
            Notifications::create([
                'users_id'             => $job->poster_id,
                'title'                => $title,
                'status'               => 0,
                'message'              => $body,
                'notification_type_id' => NotificationTypes::COMPLETED_JOB,
            ]);

            $this->firebaseService->sendNotification($deviceToken, $title, $body);
        }
        
        $job->update(['is_complete' => true]);
        return response()->json(['worker job completed successfully.']);
    }
    
    public function geClientDeclineJob(Request $request)
    {
        $jobs = Job::whereHas('jobHistory', function ($query)use($request){
            return $query->where('status', Job::NEW)->where('client_id',$request->userId);
        })->with('jobHistory', function ($query)use($request){
                return $query
                    ->where('status', Job::NEW)
                    ->where('client_id',$request->userId)
                    ->with('client','worker');
            })
            ->skip($request->start)->take($this->settings->job_limit)
            ->where('status', Job::NEW)
            ->where('poster_id', @$request->userId)
            ->orderBy("id", "desc")
            ->get();

        return response()->json($jobs);
    }

    public function geWorkerDeclineJob(Request $request)
    {
        $jobs = Job::whereHas('jobHistory', function ($query)use($request){
            return $query->where('status', Job::HIRED)->where('worker_id',$request->userId);
        })
            ->with('jobHistory', function ($query)use($request){
                return $query
                    ->where('worker_id',$request->userId)
                    ->where('status', Job::HIRED)->with('client','worker');
            })
            ->skip($request->start ?? 0)->take($this->settings->job_limit)
            ->orderBy("id", "desc")
            ->get();

        return response()->json($jobs);
    }
    
    public function job_list(Request $request, $start, $status)
    {
        $data['jobList'] = Job::
            whereDoesntHave('application')
            ->select(
                'jobs.id',
                'jobs.title',
                'jobs.job_type',
                'jobs.price',
                'jobs.poster_id',
                'jobs.disable_ids',
                'jobs.is_complete',
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
            ->whereNull('jobs.deleted_at')
            ->when(!empty($request->userId), function ($query) use ($request) {
                $query->where(function($query)use($request){
                    $query->whereJsonDoesntContain('jobs.exclude_users', (int)$request->userId)
                        ->orWhereNull('jobs.exclude_users');
                });
            })
            ->skip($start)->take($this->settings->job_limit)
            ->orderBy("id", "desc")
            ->get();

        $data['totalJob'] = Job::whereDoesntHave('application')
            ->where('jobs.status', $status)->count();

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
                'users.avatar as rImg',
                'applications.jobs_id'
            )
            ->join('applications', 'applications.users_id', '=', 'users.id')
            ->where('applications.jobs_id', $jobId)
            ->orderBy("id", "asc")
            ->get()
        ->filter(function ($item)use($jobId){
           return Job::where('id',$item->jobs_id)->where('status',Job::NEW)->exists(); 
        });
        
        return response()->json($data);
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
                'skill_list' => $data->skills,
                'exclude_users' => null,
                'disable_ids' => null,
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
            ->whereNull('jobs.deleted_at')
            ->orderBy("id", "desc")
            ->first();
        return response()->json($data);
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
    
    //calling if worker hired status = 2
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
                'jobs.status',
                'jobs.disable_ids',
                'jobs.is_complete',
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
            ->whereNull('jobs.deleted_at')
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
    
    public function complete_hire(Request $request)
    {
        $success = $request->userInput;
//        $success = json_encode($success);
        $data = json_decode($success);
        $job = Job::where('id', $data->jobId)
            ->update([
                'awards_id' => $data->userId,
                'final_price' => $data->amount,
                'status' => Job::HIRED
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

    //reject client
    public function rejectWorkerByClient(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $job = Job::findOrFail($input['job_id']);
            $application = Application::where('jobs_id', $job->id)->first();
            
            JobHistory::updateOrCreate(
                [
                    'job_id'  => $job->id,
                    'worker_id' => $application->users_id,
                    'client_id' => $job->poster_id,
                    'status'  => Job::NEW,
                ]
                ,[
                'reason'  => $request->reason,
                'job_id'  => $job->id,
                'worker_id' => $application->users_id,
                'client_id' => $job->poster_id,
                'status'  => $job->status,
            ]);

            $excludeUsers = $job->exclude_users;
            if (!empty($excludeUsers) && in_array($application->users_id,$excludeUsers)){
                $excludeUsers =  array_filter($excludeUsers, function ($item)use($application) {
                    return $item !== $application->users_id;
                });
                $excludeUsers = count($excludeUsers) > 0  ? $excludeUsers  : null;
            }
            
           
            $job->update([
                'exclude_users' => $excludeUsers,
                ]);
            $application->delete();
            DB::commit();

            return response([
                'message' => 'Job rejected Successfully',
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json($exception->getMessage());
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
            ->whereNull('jobs.deleted_at')
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
            ->whereNull('jobs.deleted_at')
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
//        $success = json_encode($success);
        $data = json_decode($success);
        DB::beginTransaction();
        try {
            if ($data->status == Job::DECLINE) {
                $jobData = DB::table('jobs')->whereNull('deleted_at')->where('id', $data->jobId)->first();
                $application = Application::where('jobs_id', $data->jobId)
                    ->where('users_id', $jobData->awards_id)->first();

                JobHistory::updateOrCreate(
                    [
                        'job_id'  => $jobData->id,
                        'worker_id' => $application->users_id,
                        'client_id' => $jobData->poster_id,
                        'status' => Job::HIRED
                    ]
                    ,[
                    'reason'  => @$data->reason,
                    'job_id'  => $jobData->id,
                    'worker_id' => $application->users_id,
                    'client_id' => $jobData->poster_id,
                    'status'  => $jobData->status,
                ]);

                $excludeUsers = @$jobData->exclude_users ?? [];
                if(is_string($excludeUsers)){
                    $excludeUsers = json_decode($excludeUsers,true);
                }
                if (empty($excludeUsers)) {
                    $excludeUsers = [$jobData->awards_id];
                } else {
                    array_push($excludeUsers, $jobData->awards_id);
                }

                DB::table('jobs')->whereNull('deleted_at')->where('id', $data->jobId)->update([
                    'awards_id' => null,
                    'final_price' => null,
                    'status' => Job::NEW,
                    'exclude_users' => $excludeUsers
                ]);
                $application->delete();
            } else {
                DB::table('jobs')->whereNull('deleted_at')->where('id', $data->jobId)->update(['status' => $data->status]);
            }     
            DB::commit();
            $statusMsg = $data->status == Job::DECLINE ? 'decline' : 'accept';
            
            return response()->json("job $statusMsg successfully");
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception->getMessage(), $exception->getCode());
        }
    }

    public function complete_review(Request $request)
    {
        $success = $request->userInput;
        $data = json_decode($success);
        if ($data->type == 'client') {
            $jobData = DB::table('jobs')->whereNull('deleted_at')->where('id', $data->jobId)->first();
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

        DB::table('jobs')->whereNull('deleted_at')->where('id', $data->jobId)->update($arr);
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

        $userDocuments = Document::toBase()->where('user_id', $id)->select('type', 'document_url', 'status')->get();


//        if ($userDocuments->count() > 0) {
//            if ($data['userInfo']->insurance_img) {
//                $userDocuments->push([
//                    'document_url' => $data['userInfo']->insurance_img,
//                    'type' => 'insurance_img'
//                ]);
//            }
//        }

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
        
        Job::findOrFail($request->job_id)->update(['status' => Job::COMPLETE]);

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
            ->whereNull('jobs.deleted_at')
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
    
    public function destroy($id){
        $job = Job::where('id', $id)->first();
        if (empty($job)){
            return response()->json(['errorMessage' => 'job is not found.'], 404);
        }
        $job->delete();
        return response()->json(['successMessage' => 'job deleted successfully.']);
    }
}
