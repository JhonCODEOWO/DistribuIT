<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->hasProducts(5)->create();
        User::factory()->count(5)->hasSales(5)->create();
        User::factory()->count(5)->create();
        User::factory()->create(["name" => 'admin', "email" => 'prueba@prueba.com', "password" => 'admin']);
    }
}
