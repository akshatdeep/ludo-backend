<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTranscationDetails extends Model
{
    protected $table = 'wallet_transcation_details';
    protected $fillable = [
        'player_id',
        'wallet_id',
        'amount',
        'trans_date',
        'type',
        'use_of',
        'notes',
        'wallet_type'
    ];

    public function playerId()
    {
        return $this->hasOne('App\User', 'id','player_id');
    }
    public function walletId()
    {
        return $this->hasOne('App\Models\WalletDetail', 'id','wallet_id');
    }
}
