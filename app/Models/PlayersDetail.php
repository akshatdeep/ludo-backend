<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayersDetail extends Model
{
    protected $table = 'player_details';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'refer_code',
        'join_code',
        'no_of_participate',
        'no_of_loose',
        'no_of_total_win',
        'no_of_2win',
        'no_of_4win',
        'device_type',
        'device_token',
        'profile_url_image',
        'profile_image',
        'banned'
    ];

    public function wallet_id()
    {
        return $this->hasOne('App\Models\WalletDetail', 'player_id','user_id');
    }

    public function bonus_wallet_id()
    {
        return $this->hasOne('App\Models\BonusWalletDetail', 'player_id','user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
