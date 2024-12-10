<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentCategorySearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'keyword',
        'user_id'
    ];
}
