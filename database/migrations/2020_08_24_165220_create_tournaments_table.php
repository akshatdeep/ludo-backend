<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tournament_name');
            $table->string('bet_amount');
            $table->string('commission');
            $table->string('no_players');
            $table->string('no_of_winners');
            $table->string('two_player_winning')->nullable();
            $table->string('four_player_winning_1')->nullable();
            $table->string('four_player_winning_2')->nullable();
            $table->string('four_player_winning_3')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('tournament_interval')->nullable();
            $table->integer('status')->default(1)->comment('1 - yet_to_start, 2 - started, 3 - completed, 4 - cancelled');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
