<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();
        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => '1',
                'first_name'=> 'sriram',
                'email' => 'sriram4buddy@gmail.com',
                'email_verified_at' => '2013-06-11 07:47:40',
                'password' =>  Hash::make('admin123'),
                'mobile_no' => '7502223330',
                'user_type' =>'1',
                'status' => '1',
                'created_at' => '2013-06-11 07:47:40',
                'updated_at' => '2013-06-11 07:47:40',
            ),
            
        ));
        // \DB::table('users')->delete();
 
        
    }
}