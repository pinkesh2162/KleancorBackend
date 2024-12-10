<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseKeepingRadio extends Model
{
    use HasFactory;

    protected $fillable = [
        'posting_title',
        'display_title',
        'category_id',
        'label_list',
        'serial',
        'status'        
    ];
}
