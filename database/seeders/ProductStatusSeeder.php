<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->environment('production') && ProductStatus::count() === 0){
            ProductStatus::factory()->create(['name'=>'disabled']);
            ProductStatus::factory()->create(['name'=>'available']);
            return;
        }

        ProductStatus::factory()->create(['name'=>'disabled']);
        ProductStatus::factory()->create(['name'=>'available']);
    }
}
