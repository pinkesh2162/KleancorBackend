<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'user_id',
        'document_url',
        'type',
    ];
    
//    type
    const OFFICIAL_ID = 'official_id';
    const CERTIFICATE = 'certificate';
    const RESUME = 'resume';
    
//    image type check
    const IMAGE = 'image';
}
