<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

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
        'exclude_users',
        'disable_ids',
        'is_complete'
    ];

    protected $casts = [
        'exclude_users' => 'json'
    ];

    // status of job
    const NEW = 1;
    //inprogress 2
    const HIRED = 2;
    const ACCEPT = 3;
//     const WORKER_COMPLETE = 4;
    const COMPLETE = 5;
    const DECLINE = 6;
    const CLOSE = 7;
    
    public function location(){
        return $this->belongsTo(Location::class,'locations_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'categories_id','id');
    }
    
    public function user(){
        return $this->belongsTo(User::class,'poster_id','id');
    }
    
    public function jobHistory(){
        return $this->hasMany(JobHistory::class,'job_id','id');
    }
    
    public function application(){
        return $this->hasOne(Application::class,'jobs_id','id');
    }
    
    public function scopeFilter($query, $filter)
    {
        return $query
            ->when(isset($filter['status']) && ! empty($filter['status']), function ($qr) use ($filter) {
                return $qr->where('status', $filter['status']);
            })
            ->when(isset($filter['exclude_user']) && ! empty($filter['exclude_user']), function ($qr) use ($filter) {
                return $qr->where(function ($query)use($filter){
                    $query->whereJsonDoesntContain('exclude_users', (int)$filter['exclude_user'])
                        ->orWhereNull('exclude_users');
                });
            });
    }
}
