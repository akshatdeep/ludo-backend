<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = 'tournaments';
    protected $fillable = [
        'tournament_name',
        'bet_amount',
        'commission',
        'no_players',
        'no_of_winners',
        'two_player_winning',
        'four_player_winning_1',
        'four_player_winning_2',
        'four_player_winning_3',
        'start_time',
        'end_time',
        'tournament_interval',
        'status'
    ];

}
