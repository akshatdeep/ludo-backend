<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');          
            $table->string('first_name');
            $table->string('last_name');           
            $table->string('refer_code')->nullable();
            $table->string('join_code')->nullable();
            $table->string('no_of_participate')->nullable();           
            $table->string('no_of_loose')->nullable();
            $table->string('no_of_total_win')->nullable();
            $table->string('no_of_2win')->nullable();
            $table->string('no_of_4win')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->string('profile_url_image')->nullable();
            $table->string('profile_image')->nullable();
            $table->boolean('banned')->default(0)->comment('1 - Yes, 0 - No');
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
        Schema::dropIfExists('player_details');
    }
}
