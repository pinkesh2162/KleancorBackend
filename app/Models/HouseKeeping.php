<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseKeeping extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name',
        'min_val',
        'max_val',
        'default_val',
        'category_id',
        'status'
    ];
}
