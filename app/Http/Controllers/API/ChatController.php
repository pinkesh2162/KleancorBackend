<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notifications;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {

        event(
            new MessageSent(
                $request->input('sender_id'),
                $request->input('receiver_id'),
                $request->input('message'),
                $request->input('channelId')
            )
        );

        $result = DB::table('channels')->where('name', $request->channelId)->first();
        if (!$result) {
            DB::table('channels')->insert([
                'name' => $request->channelId,
                'sender_id' =>  $request->sender_id,
                'receiver_id' => $request->receiver_id
            ]);
        }
        //DB::table('test_table')->insert(['name'=>$request->channelId . "===" . $request->sender_id . "===" . $request->receiver_id]);

        $result = DB::table('channels')->where('name', $request->channelId)->first();

        $message = Message::create([
            'message' => $request->message,
            'channel_id' => $result->id,
            'sender_id' =>  $request->sender_id,
            'receiver_id' => $request->receiver_id
        ]);

        $notification = Notifications::create([
            'users_id' =>  $request->receiver_id,
            'title' => "Send Message",
            'status' => 0,
            'message' => $request->message,
        ]);


        return  $message;
    }

    public function chat_history($userId)
    {
        $result = DB::table('channels')
            ->select(
            'channels.name',
            'su.id as sid',
            'ru.id as rid',
            'su.first_name as su_fn',
            'su.last_name as su_ln',
            'su.avatar as sImg',
            'ru.avatar as rImg',
            'ru.first_name as ru_fn',
            'ru.last_name as ru_ln',
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
