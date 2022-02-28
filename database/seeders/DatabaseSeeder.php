<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Board;
use App\Models\Group;
use App\Models\Card;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        Board::unguard();
        Group::unguard();
        Card::unguard();
        Comment::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Board::truncate();
        Group::truncate();
        Card::truncate();
        Comment::truncate();

        $this->call([
            UserSeeder::class,
            BoardSeeder::class,
            GroupSeeder::class,
            CardSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
