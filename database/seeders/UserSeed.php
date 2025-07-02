<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Sale;
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
        if(app()->environment('production')) {
            User::factory()->create(["name" => 'admin', "email" => 'prueba@prueba.com', "password" => 'admin']);
            return;
        }
        
        $users = User::factory()
                    ->count(5)
                    ->create()
                    ->each(function($user){ //Callback para acceder a cada usuario creado
                        //Crear data relacionada a cada usuario

                        $products = Product::factory()->count(2)->for(ProductStatus::factory()->state(["name" => "available"]))->create();

                        $sales = Sale::factory()->count(2)->for($user)->create();

                        foreach($sales as $sale){
                            $productToAttach = $products->random(2);
                            $dataToAttach = array();

                            //Make data to attach id => pivot_data
                            foreach ($productToAttach as $product) {
                                $quantity = 2;
                                $dataToAttach[$product->id] = ["quantity" => $quantity, "subtotal" => $quantity * $product->price];
                            }

                            $sale->products()->attach($dataToAttach);
                        }
                    });

        //Crear dos usuarios sin registros
        User::factory()->count(2)->create();
        User::factory()->create(["name" => 'admin', "email" => 'prueba@prueba.com', "password" => 'admin']);
    }
}
