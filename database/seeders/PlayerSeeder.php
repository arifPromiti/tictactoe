<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'game_id' => 1,
                'name' => 'Arif',
                'sign' => 'X',
                'move_count' => 0,
                'status' => 0
            ],
            [
                'game_id' => 1,
                'name' => 'Rofique',
                'sign' => '0',
                'move_count' => 0,
                'status' => 0
            ]
        ];
        DB::table('Players')->insert($data);
    }
}
