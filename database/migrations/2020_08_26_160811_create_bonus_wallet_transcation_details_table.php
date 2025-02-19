<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusWalletTranscationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_wallet_transcation_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('player_id');
            $table->integer('wallet_id');
            $table->integer('trounament_id');
            $table->double('amt_used',10,2);
            $table->date('amt_used_date')->nullable();
            $table->integer('status')->default(1)->comment('1 - Pending, 2 - Rejected, 3 - Approved');
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
        Schema::dropIfExists('bonus_wallet_transcation_details');
    }
}
