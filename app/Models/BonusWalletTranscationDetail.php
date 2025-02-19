<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusWalletTranscationDetail extends Model
{
    protected $table = 'coupon';
    protected $fillable = [
        'player_id',
        'wallet_id',
        'coupon_bonus',
        'upi _money',
        'offer',
        'cool_twenty',
        'win_twenty',
        'UPI_offer',
        'xtra_ten',
        'play_ten',
        'UPI_offer_lastused',
        'xtra_ten_lastused',
        'play_ten_lastused',
    ];

    public function player_id()
    {
        return $this->hasOne('App\Models\PlayersDetail', 'id','player_id');
    }

    public function wallet_id()
    {
        return $this->hasOne('App\Models\BonusWalletDetail', 'id','wallet_id');
    }

    public function trounament_id()
    {
        return $this->hasOne('App\Models\Tournament', 'id','trounament_id');
    }
}
