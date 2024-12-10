<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'payment_id', 
        'client_id',
        'worker_id',
        'job_category_id',
        'amount',
        'status',
        'total_hour',
        'payment_date',
        'last_update'
    ];
}
