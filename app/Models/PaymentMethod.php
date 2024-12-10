<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_type',
        'paypal_email',
        'first_name',
        'last_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'phone',
        'bank_name',
        'account_number',
        'routing_number',
        'card_type',
        'card_number',
        'exp_month',
        'exp_year',
        'cvv',
        'status'
    ];
}
