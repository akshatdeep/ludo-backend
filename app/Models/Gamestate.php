<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamestate extends Model
{
    protected $table = 'gamestate';
    protected $fillable = [
        'roomid',
        'state'
        
    ];

    
}
