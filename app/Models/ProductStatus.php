<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    /** @use HasFactory<\Database\Factories\ProductStatusFactory> */
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class);
    }
}
