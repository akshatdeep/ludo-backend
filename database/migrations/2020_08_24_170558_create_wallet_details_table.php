<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('player_id');
            $table->string('wallet_ref_number');
            $table->double('total_amt_load',10,2);
            $table->double('total_amt_withdraw',10,2);
            $table->double('current_amount',10,2);
            //special amount -- bonus....
            $table->string('no_of_load')->nullable();
            $table->string('no_of_withdraw')->nullable();
            $table->date('last_withdraw_date')->nullable();
            $table->date('last_load_date')->nullable();
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
        Schema::dropIfExists('wallet_details');
    }
}
