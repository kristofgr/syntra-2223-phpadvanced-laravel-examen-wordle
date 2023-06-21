<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Kristof',
            'email' => 'kristof@nizer.be',
            'password' => Hash::make('rootpass'),
        ]);

        DB::table('words')->insert([
            'word' => 'floor',
            'sheduled_at' => date('Y-m-d', strtotime('-1 day')),
            'created_at' => now(),
        ]);

        DB::table('words')->insert([
            'word' => 'chips',
            'sheduled_at' => date('Y-m-d'),
            'created_at' => now(),
        ]);

        DB::table('words')->insert([
            'word' => 'salsa',
            'sheduled_at' => date('Y-m-d', strtotime('+1 day')),
            'created_at' => now(),
        ]);
    }
}
