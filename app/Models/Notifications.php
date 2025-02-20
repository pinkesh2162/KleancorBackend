<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;


    protected $fillable = [
     'users_id',
     'title',
     'message',
        'status',
        'notification_type_id',
    ];
}
