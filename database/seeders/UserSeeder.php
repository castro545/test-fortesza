<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * create 30 users
     * @return void
     */
    
    public function run()
    {
        \App\Models\User::factory()->count(30)->create(); 
    }
}
