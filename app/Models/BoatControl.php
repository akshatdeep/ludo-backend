<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatControl extends Model
{
    protected $table = 'boat_controls';
    protected $fillable = [
        'boat_status',
        'boat_complexity',
    ];
}
