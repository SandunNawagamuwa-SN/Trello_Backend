<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
                'name' => 'Planned',
                'board_id' => 1,
            ]
        );
        
        DB::table('groups')->insert([
                'name' => 'Inprogress',
                'board_id' => 1,
            ]
        );

        DB::table('groups')->insert([
                'name' => 'Completed',
                'board_id' => 1,
            ]
        );
        
        DB::table('groups')->insert([
                'name' => 'Reviewed',
                'board_id' => 1,
            ]
        );

        DB::table('groups')->insert([
                'name' => 'Self Leranings',
                'board_id' => 2,
            ]
        );

        DB::table('groups')->insert([
                'name' => 'School Leranings',
                'board_id' => 2,
            ]
        );

        DB::table('groups')->insert([
                'name' => 'Class Leranings',
                'board_id' => 2,
            ]
        );
    }
}
