<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusWalletDetail extends Model
{
    protected $table = 'bonus_wallet_details';
    protected $fillable = [
        'player_id',
        'bonus_wallet_ref_number',
        'total_amt_added',
        'total_amt_used',
        'current_amount',
        'last_used_date',
        'last_added_date'
    ];

    public function player_id()
    {
        return $this->hasOne('App\Models\PlayersDetail', 'id','player_id');
    }
}
