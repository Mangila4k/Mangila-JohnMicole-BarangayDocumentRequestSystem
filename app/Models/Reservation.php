<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'status',
        'approved_at',
        // other fields...
    ];

    protected $dates = [
        'approved_at',
    ];
}
    