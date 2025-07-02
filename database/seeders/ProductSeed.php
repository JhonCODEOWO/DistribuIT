<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear seed de productos, no recomendable ya que se generarían sin usuarios
        // Product::factory()->count(10)->hasImages(2)->create();
    }
}
