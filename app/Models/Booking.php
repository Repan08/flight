<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'flight_id', 'payment_id', 'promo_id', 'total_price', 'booking_status'];

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
