<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentRegistartion extends Model
{
    protected $table = 'tournament_registartion';
    protected $fillable = [
        'tournament_id',
        'player_id',
        'register_date',
        'type',
        'players',
        'play_money',
        'bonus_money',
        'room_no'
    ];
}
