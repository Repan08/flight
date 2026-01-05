<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airplane extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'airline_id', 
        'model', 
        'seat_capacity'
    ];
}
