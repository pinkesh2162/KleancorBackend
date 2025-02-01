<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
        'auth_type',
        'auth_id',
        'status',
        'refer_code',
        'official_id',
        'dob',
        'gender',
        'social_media_links',
        'skill_list',
        'address',
        'location_list',
        'about',
        'price',
        'places_id',
        'expertise_label',
        'contact',
        'insurance_img',
        'avatar',
        'client_location',
        'fcm_token',
        'is_verified_document',
        'year_of_experience',
        'service_offer',
        'availability',
        'rates',
        'service_areas',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linked_in_url',
        'payment_customer_id',
        'stripe_bank_id',
    ];

    const ACTIVE = 1;
    const DE_ACTIVE = 0;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }
    
    public function application(){
        return $this->hasOne(Application::class,'users_id','id');
    }
}
