<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
                'name' => 'admin1',
                'email' => 'admin1@global.com',
                'password' => bcrypt('admin1admin1'),
            ]
        );
        
        DB::table('users')->insert([
                'name' => 'admin2',
                'email' => 'admin2@global.com',
                'password' => bcrypt('admin2admin2'),
            ]
        );
        
    }
}
