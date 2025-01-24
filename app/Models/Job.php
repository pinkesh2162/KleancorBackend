<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'id',
        'title',
        'project_name',
        'short_description',
        'description',
        'locations_id',
        'address',
        'job_type',
        'price',
        'final_price',
        'total_amount',
        'categories_id',
        'number_of_worker',
        'hours',
        'final_hour',
        'week_type',
        'dead_line',
        'house_keeping_list',
        'house_keeping_radio_list',
        'skill_list',
        'contact',
        'awards_id',
        'poster_id',
        'house_type',
        'main_entry',
        'status',
        'client_recommended',
        'client_rating1',
        'client_rating2',
        'client_rating3',
        'client_comment',
        'worker_rating1',
        'worker_rating2',
        'worker_rating3',
        'worker_comment',
        'exclude_users'
    ];

    protected $casts = [
        'exclude_users' => 'json'
    ];

    // status of job
    const NEW = 1;
    const HIRED = 2;
    const ACCEPT = 3;
    // const CLIENT_DECLINE = 4;
    const COMPLETE = 5;
    const DECLINE = 6;
}
