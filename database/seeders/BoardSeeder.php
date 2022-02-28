<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('boards')->insert([
                'name' => 'Work',
                'user_id' => 1,
            ]
        );
        
        DB::table('boards')->insert([
                'name' => 'Study',
                'user_id' => 1,
            ]
        );

        DB::table('boards')->insert([
                'name' => 'Health',
                'user_id' => 1,
            ]
        );
        
        DB::table('boards')->insert([
                'name' => 'Work',
                'user_id' => 2,
            ]
        );

        DB::table('boards')->insert([
                'name' => 'Life',
                'user_id' => 2,
            ]
        );
    }
}
