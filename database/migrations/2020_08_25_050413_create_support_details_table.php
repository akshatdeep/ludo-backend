<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('player_id');
            $table->string('player_name');
            $table->string('player_phone');
            $table->string('email_id');
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->string('admin_reply')->nullable();
            $table->integer('status')->default(1)->comment('1 - Open, 2 - Closed');
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
        Schema::dropIfExists('support_details');
    }
}
