<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    use HasFactory;
    protected $table = 'job_history';
    protected $fillable = [
      'reason',
      'job_id',
      'status',
      'worker_id',
      'client_id',
      'decline_by',
      'type'
    ];
    
    const WORKER = 1;
    const CLIENT = 2;
    public function worker(){
        return $this->belongsTo(User::class,'worker_id','id');
    }
    
    public function client(){
        return $this->belongsTo(User::class,'client_id','id');
    }

    public function job(){
        return $this->belongsTo(Job::class,'job_id','id');
    }
}
