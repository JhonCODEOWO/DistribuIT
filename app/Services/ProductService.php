<?php

namespace App\Services;

use App\Models\Product;

class ProductService {
    public function findOne(string $id): Product | null{
        $product = null;
        if(ctype_digit($id)) {
            $product = Product::findOrFail($id);
        } else {
            $product = Product::where('slug', $id)->first();
        }

        return $product;
    }
}