<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'spanish_name',
        'picture',
        'commission',
        'status'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'category_skills');
    }
}
