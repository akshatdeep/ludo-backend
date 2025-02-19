<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletDetail extends Model
{
    protected $table = 'wallet_details';
    protected $fillable = [
        'player_id',
        'wallet_ref_number',
        'total_amt_load',
        'total_amt_withdraw',
        'current_amount',
        'no_of_load',
        'no_of_withdraw',
        'last_withdraw_date',
        'last_load_date',
    ];

    public function player_id()
    {
        return $this->hasOne('App\Models\PlayersDetail', 'user_id','player_id');
    }
   
}
