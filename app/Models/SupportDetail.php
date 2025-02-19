<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportDetail extends Model
{
    protected $table = 'support_details';
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'email',
        'subject',
        'message',
        'status'
    ];

    public function playerId()
    {
        return $this->hasOne('App\User', 'id','player_id');
    }
}
