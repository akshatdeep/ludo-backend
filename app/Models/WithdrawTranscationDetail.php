<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawTranscationDetail extends Model
{
    protected $table = 'withdraw_transcation_details';
    protected $fillable = [
        'player_id',
        'wallet_id',
        'withdraw_request_date',
        'amt_withdraw',
        'withdraw_date',
        'payment_type',
        'account_number',
        'ifsc_code',
        'transcation_number',
        'mobile_number',
        'notes',
        'status'
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
