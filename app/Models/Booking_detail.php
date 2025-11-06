<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking_detail extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'flight_id', 'payment_id', 'promo_id', 'total_price', 'booking_status'];
}
