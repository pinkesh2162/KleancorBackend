<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notifications;
use App\Services\FirebaseService;
use App\Constants\NotificationTypes;

class ChatController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendMessage(Request $request)
    {
        
        event(new MessageSent(
            $request->input('sender_id'), 
            $request->input('receiver_id'), 
            $request->input('message'),
            $request->input('channelId')
            )
        );
        
        $result = DB::table('channels')->where('name', $request->channelId)->first();
        if(!$result) {
            DB::table('channels')->insert([
                    'name'=>$request->channelId, 
                    'sender_id' =>  $request->sender_id,            
                    'receiver_id' => $request->receiver_id
                    ]);
        }
         //DB::table('test_table')->insert(['name'=>$request->channelId . "===" . $request->sender_id . "===" . $request->receiver_id]);
        
        $result = DB::table('channels')->where('name', $request->channelId)->first();

        $senderUser = DB::table('users')
        ->select(
            'first_name',
            'last_name',
            'fcm_token'
        )
        ->where('id', $request->sender_id)->first();

        $reciverUser = DB::table('users')
        ->select(
            'first_name',
            'last_name',
            'fcm_token'
        )
        ->where('id', $request->receiver_id)->first();

        $senderName = "";
        if (isset($senderUser->first_name)) {
            $senderName = trim(ucwords($senderUser->first_name . " " . $senderUser->last_name));
        }
        $title = $senderName . " Send A Message.";

        $message = Message::create([
            'message' => $request->message,
            'channel_id' => $result->id,
            'sender_id' =>  $request->sender_id,            
            'receiver_id' => $request->receiver_id
        ]);

        $notification = Notifications::create([
            'users_id' =>  $request->receiver_id,
            'title' => $title,
            'status' => 0,
            'message' => $request->message,
            'notification_type_id' => NotificationTypes::SEND_MESSAGE
        ]);

        if ($reciverUser->fcm_token != null) {
            $deviceToken = $reciverUser->fcm_token;
            $title = $title;
            $body = $request->message;

            $response = $this->firebaseService->sendNotification($deviceToken, $title, $body);
        }

        return  $message;
    }
    
    public function chat_history($userId) {
        $result = DB::table('channels')
                        ->select(
                                    'channels.name', 'su.id as sid', 'ru.id as rid', 
                                    'su.first_name as su_fn', 'su.last_name as su_ln','su.avatar as sImg','ru.avatar as rImg',
                                    'ru.first_name as ru_fn', 'ru.last_name as ru_ln',
                                    DB::raw("(select message from messages where channels.id=messages.channel_id order by messages.id desc limit 1) as last_message")
                                )
                        ->leftJoin('users as su', 'su.id', '=', 'channels.sender_id')
                        ->leftJoin('users as ru', 'ru.id', '=', 'channels.receiver_id')
                        ->where('channels.sender_id', $userId)
                        ->orWhere('channels.receiver_id', $userId)
                        ->orderBy('channels.updated_at', 'desc')
                        ->get();
                        
                        
        return response()->json($result);                
    }
    
    


    public function getMessages($channel_name)
    {
        $result = DB::table('channels')
                        ->select('messages.sender_id', 'messages.receiver_id', 'messages.message')
                        ->join('messages', 'messages.channel_id', '=', 'channels.id')
                        ->where('channels.name', $channel_name)
                        ->orderBy('messages.id', 'desc')
                        ->get();
        return response()->json($result);                
    }
    

}