<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('todolists')->insert([
            'user_id' => 2,
            'task_name' => 'Fix the coffee machine',
            'end_date' => '2022-11-28 00:00:00.000000',
            'status' => 'PENDING',
            'assigned_to' => null,
        ]);
    }
}
