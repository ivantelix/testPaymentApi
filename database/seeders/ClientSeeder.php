<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            [
                'email' => 'client1@gmail.com',
                'join_date' => date('Y-m-d')
            ],
            [
                'email' => 'client2@gmail.com',
                'join_date' => date('Y-m-d')
            ],
            [
                'email' => 'client3@gmail.com',
                'join_date' => date('Y-m-d')
            ],
            [
                'email' => 'client4@gmail.com',
                'join_date' => date('Y-m-d')
            ],
        ];

        DB::table('clients')->insert($clients);
    }
}
