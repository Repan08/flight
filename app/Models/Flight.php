<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'airplane_id', 
        'origin', 
        'destination', 
        'departure_time', 
        'arrival_time', 
        'price'
    ];
}
