<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusWalletDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_wallet_details', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->integer('player_id');
            $table->integer('wallet_id');
            $table->string('type');
            $table->string('use_of');
            $table->string('notes');
            $table->double('amount',10,2);
            $table->date('trans_date')->nullable();
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
        Schema::dropIfExists('bonus_wallet_details');
    }
}
